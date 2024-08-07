<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Search;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;  
use App\Helpers\ErrorHelper;
use Exception;
use Illuminate\Validation\ValidationException;

class SearchController extends Controller
{
    
    public function select_user($user_search_id){



        try {  
            request()->validate(
                [
                'age'=>['required'],
                'age2'=>['required']
                ],
                [
                    'age.required'=>['پر کردن فیلد سن ضروری است']
                ]
        
           );

          

            $search = new Search();
            $search->user = request()->user()->id ;
            $search->user_search = $user_search_id ;
            $search->date = now();
            $search->save();
            return response()->json(['success'=>true,'return_user_id'=>$user_search_id],200);

            
        } 

        catch (ValidationException $e) {  
            // Handle validation errors  
            return response()->json([  
                'message' => 'خطای اعتبارسنجی اتفاق افتاده است. لطفا ورودی ها را بررسی کنید',  
                'errors' => $e->errors(),  
            ], 422); 
        }
        
        catch (Exception $e) {  
            // Handle any other exceptions  
            return ErrorHelper::handleError($e);  
        }  
        
        
        // catch (ModelNotFoundException $e) {  
        //     return response()->json(['success' => false, 'message' => 'User not found.'], 404);  
        // } catch (\Exception $e) {  
        //     // Handle any other exceptions  
        //     return response()->json(['success' => false, 'message' => 'خطایی اتفاق افتاده است'], 500);  
        // }  




        
    
    }
}
