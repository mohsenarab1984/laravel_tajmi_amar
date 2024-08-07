<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Inertia\Inertia;

class UserController extends Controller
{
    public function search_name(Request $request){
        $user_name = $request->q ;
        $users = User::where('name','like','%'.$user_name.'%')->get() ;
        return response()->json(['results'=>$users]) ;
    }

    public function all_user(){
        //return response()->json(['users'=>User::all()]) ;
        $users=User::all();
        
        return Inertia::render('Admin/Users/Index',['users'=>User::all()]);
    }
}
