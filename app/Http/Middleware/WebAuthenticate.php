<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class WebAuthenticate
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
        if (Auth::check() == true && in_array(0, array(Auth::user()->activate, Auth::user()->confirm)) or empty(Auth::user()->id)) {
            Auth::guard('web')->logout(); 
            return  redirect()->route('login');
        }    
        return $next($request);
    }
}
