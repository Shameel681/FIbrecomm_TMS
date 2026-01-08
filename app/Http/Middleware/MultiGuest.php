<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class MultiGuest
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        // If an HR is logged in and tries to access Index or Login, bounce them to HR Dashboard
        if (Auth::guard('hr')->check()) {
            return redirect()->route('hr.dashboard');
        }

        // If a Supervisor is logged in, bounce them to Supervisor Dashboard
        if (Auth::guard('supervisor')->check()) {
            return redirect()->route('supervisor.dashboard');
        }

        // If a Trainee is logged in, bounce them to Trainee Dashboard
        if (Auth::guard('trainee')->check()) {
            return redirect()->route('trainee.dashboard');
        }

        return $next($request);
    }
}