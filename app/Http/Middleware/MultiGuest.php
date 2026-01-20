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
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is logged in using the default guard
        if (Auth::check()) {
            $user = Auth::user();

            // Redirect them away from guest pages (like login/index) 
            // to their respective dashboards based on their role
            return match ($user->role) {
                'admin'      => redirect()->route('admin.dashboard'),
                'hr'         => redirect()->route('hr.dashboard'),
                'supervisor' => redirect()->route('supervisor.dashboard'),
                'trainee'    => redirect()->route('trainee.dashboard'),
                default      => redirect('/'),
            };
        }

        return $next($request);
    }
}