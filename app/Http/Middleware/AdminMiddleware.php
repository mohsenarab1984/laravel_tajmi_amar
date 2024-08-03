<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Inertia\Inertia;

class AdminMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        // if(!request()->user() || (request()->user() && request()->user()->is_admin==0)){
        //    return redirect('admin/login');
            
        // }
        if(!request()->user()){
           return redirect('/login');
            
        }

        if($request->user()?->is_admin == 1){

            return $next($request);
        }

        //dd('oxh');
        return back()->withErrors(['myErrorText' => 'شما مجوز ادمین را ندارید']);

        return $next($request);
    }
}
