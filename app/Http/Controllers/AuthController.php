<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Inertia\Inertia;

class AuthController extends Controller
{
    public function login_check(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
           
            if(Auth::user()->is_admin==1){
                //dd(Auth::user(),'is_admin==1');
                return redirect('/admin');
            }else{
                //dd(Auth::user(),'is_admin==0');
                return redirect('/');

            }
        }

        throw ValidationException::withMessages([
            'username' => 'Invalid credentials',
        ]);
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login');
    }
}
