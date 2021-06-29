<?php

namespace App\Http\Middleware;

use Closure;
use Auth;

class CheckBanned
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
        if (Auth::check() && Auth::user()->isBanned()) {
        
            Auth::logout();

            $message = '因您違反相關規定遭人檢舉，所以從即日起帳號被停用，請寄信和管理人員聯繫';

            return redirect()->route('login')->with('danger', $message);
        }

        return $next($request);
    }
}
