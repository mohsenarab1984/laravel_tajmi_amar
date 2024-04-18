<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class ExcludeFromPageExpiration
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // $user = Auth::user();
        // if ($request->path() == 'logout'  && $user) { 
        //     Auth::logout();
        //     $request->session()->invalidate();
        //     $request->session()->regenerateToken();
        //     return redirect('/login');
        // }
        return $next($request);
    }
}
