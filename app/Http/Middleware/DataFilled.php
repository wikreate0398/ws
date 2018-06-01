<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class DataFilled
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
        if (Auth::user()->data_filled == 0) 
        {
            if (request()->ajax()) {
                return response()->json(['error' => 'page not available'], 404);
            }  
            return redirect()->route(userRoute('user_edit'));
        }
 
        return $next($request);
    }
}
