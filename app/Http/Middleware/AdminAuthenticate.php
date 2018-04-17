<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class AdminAuthenticate
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
 
        if ($request->segment(1) == 'admin') {   
            Auth::shouldUse('admin');
        }

        if (Auth::check() == false) {
            return redirect()->route('admin_login'); 
        } 

        return $next($request);
    }
}
