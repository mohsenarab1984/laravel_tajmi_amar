<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Search;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\ModelNotFoundException;  
use App\Helpers\ErrorHelper;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class SearchController extends Controller
{
    
    public function select_user($user_search_id){



        try {  
        //     request()->validate(
        //         [
        //         'age'=>['required'],
        //         'age2'=>['required']
        //         ],
        //         [
        //             'age.required'=>'پر کردن فیلد سن ضروری است'
        //         ]
        
        //    );

          ///  Search::find(12345)->name;
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

    public function frequest_search(){
        try{

            $current_user_id = request()->user()->id;

            // *******************************  working
            // $searchedUsers =  DB::table('searches')
            // ->select('user_search',DB::raw('count(*) as count_search'))
            // ->where('user',$current_user_id)
            // ->groupBy('user_search')
            // ->orderBy('count_search','desc')
            // ->get() ;
            // *********************************************

            // $searchedUsers =  DB::table('searches')
            // ->select('user_search',DB::raw('count(*) as count_search'))
            // ->where('user',$current_user_id)
            // ->groupBy('user_search')
            // ->orderBy('count_search','desc')
            // ->get() ;

            // $searchedUsers = DB::table('searches')
            // ->join('users', 'searches.user_search', '=', 'users.id')
            // ->select('users.*', DB::raw('count(*) as count_search'))
            // ->where('searches.user', $current_user_id)
            // ->groupBy('searches.user_search', 'users.id')
            // ->orderBy('count_search', 'desc')
            // ->get();

            /////// working [with User] **********************************************************
            $searchedUsers = DB::table('searches')
            ->join('users', 'searches.user_search', '=', 'users.id')
            ->select('users.id as id', 'users.name as name', DB::raw('count(*) as count_search'))
            ->where('searches.user', $current_user_id)
            ->groupBy('searches.user_search', 'users.id', 'users.name')
            ->orderBy('count_search', 'desc')
            ->get();
            /////// *******************************************************************

            
            return response()->json(['data'=>$searchedUsers]) ;
            


            
          /////  $userSearchArray = $searchedUsers->pluck('user_search')->toArray();

         /////   $searched_users = User::whereIn('id',$userSearchArray)->get() ;

         ///  return response()->json(['data'=>$searched_users]) ;

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

      

        
     
    }
}