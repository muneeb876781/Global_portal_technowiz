<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;


class OrganizerAuth
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is authenticated with the 'organizer' guard
        if (!Auth::guard('organizer')->check()) {
            return redirect()->route('home'); // If not authenticated, redirect to login page
        }

        return $next($request); // Allow access if authenticated
    }
}
