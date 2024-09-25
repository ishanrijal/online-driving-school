<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // check if the user is logged in and role is instructor
        if( Auth::check() && ( Auth::user()->role === 'admin' || Auth::user()->role === 'superadmin') )
        {
            return $next($request);
        }
        // Redirect or throw an error if the user is not authorized
        return redirect()->route('home')->with('error', 'You are not authorized to access this page.');
    }
}
