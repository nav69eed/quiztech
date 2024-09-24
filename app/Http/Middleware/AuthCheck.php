<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Contracts\Session\Session;

class AuthCheck
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
        // Check if the session has a 'loginID' key, which indicates the user is logged in
        if (session()->has('loginID')) {
            // If the user is logged in, allow the request to proceed to the next middleware or controller
            return $next($request);
        } else {
            // If the user is not logged in, store the current URL in the session under 'intended_url'
            session(['intended_url' => url()->current()]);
            // Redirect the user to the login page with a failure message
            return redirect('/login')->with('fail', 'You have to Log In First');
        }
    }    
}
