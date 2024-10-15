<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle($request, Closure $next, $guard = 'organizer')
    {
        // Check if the user is already authenticated using the 'organizer' guard
        if (Auth::guard($guard)->check()) {
            // If authenticated, redirect to the organizer dashboard or a specific home page
            return redirect()->route('organizer.dashboard');
        }

        // If not authenticated, allow the request to proceed
        return $next($request);
    }

}
