<?php

namespace App\Http\Middleware;

use App\Models\Item;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class verifierMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $verifier_id = Item::findOrFail($request->id)->verifier_id ;
        if($request->user()->id == $verifier_id){

            return $next($request);
        }

        //dd('oxh');
        return back()->withErrors(['myErrorText' => 'شما مجوز لازم را ندارید']);
    }
}
