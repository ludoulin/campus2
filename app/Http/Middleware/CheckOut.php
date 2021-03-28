<?php

namespace App\Http\Middleware;

use Closure;

class CheckOut
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (Auth::check()) {
            
            if($request->product){
                dd($request->product);
            }
            return route('checkout.index');
        }
        return $next($request);
    }
}
