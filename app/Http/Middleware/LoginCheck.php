<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class LoginCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if the session has a 'loginID' key, which indicates the user is logged in.
        if (!(session()->has('loginID'))) {
            // If the user is not logged in, proceed with the next middleware or request handler.
            return $next($request);
        } else {
            // If the user is logged in, redirect them to the '/home' route.
            return redirect('dashboard');
        }
    }
}
