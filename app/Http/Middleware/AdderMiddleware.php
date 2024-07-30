<?php

namespace App\Http\Middleware;

use App\Models\Item;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdderMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $adder_id = Item::findOrFail($request->id)->adder_id ;
        if($request->user()->id == $adder_id){

            return $next($request);
        }

        //dd('oxh');
        return back()->withErrors(['myErrorText' => 'شما مجوز لازم را ندارید']);
         //return back()->with(['error' => 'Bad input provided'], 422);
    }
}
