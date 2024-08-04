<?php  

namespace App\Helpers;  

use Exception;  
use Illuminate\Database\QueryException;  
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;  
use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;  
use Illuminate\Http\JsonResponse;  

class ErrorHelper  
{  
    public static function handleError(Exception $e)  
    {  
        // Default user-friendly message  
        $userFriendlyMessage = 'An unexpected error occurred. Please try again later.';  
        $detailedErrorMessage = $e->getMessage(); // Detailed error message  

        // Check for specific exception types  
        if ($e instanceof QueryException) {  
            $errorCode = $e->errorInfo[1];  
            switch ($errorCode) {  
                case 1146: // Table not found  
                    $userFriendlyMessage = 'We encountered an issue while trying to access our data. Please try again later.';  
                    break;  
                case 23000: // Integrity constraint violation  
                    $userFriendlyMessage = 'It seems there is a conflict with the data you are trying to save.';  
                    break;  
                default:  
                    $userFriendlyMessage = 'An error occurred while accessing the database. Please try again later.';  
                    break;  
            }  
        } elseif ($e instanceof NotFoundHttpException) {  
            $userFriendlyMessage = 'The resource you are looking for was not found.';  
            return self::prepareResponse($userFriendlyMessage, 404, $detailedErrorMessage);  
        } elseif ($e instanceof AccessDeniedHttpException) {  
            $userFriendlyMessage = 'You do not have permission to access this resource.';  
            return self::prepareResponse($userFriendlyMessage, 403, $detailedErrorMessage);  
        }  

        // Handle generic errors  
        return self::prepareResponse($userFriendlyMessage, 500, $detailedErrorMessage);  
    }  

    private static function prepareResponse($userFriendlyMessage, $statusCode, $detailedErrorMessage)  
    {  
        // Check if the request expects a JSON response  
        if (request()->wantsJson()) {  
            // JSON response  
            return response()->json([  
                'message' => $userFriendlyMessage,  
                'error' => $detailedErrorMessage,  
            ], $statusCode);  
        } else {  
            // Ordinary response  
            return response($userFriendlyMessage, $statusCode);  
        }  
    }  
}