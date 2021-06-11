<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next , $guard = null)
    {
        if ( Auth::guard($guard)->check() && Auth::user()->is_admin )
        {
            return $next($request);
        }
         return abort(403, "權限不足");
    }
}
