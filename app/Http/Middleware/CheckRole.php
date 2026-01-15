<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, string $role): Response
    {
        // 1. Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('login');
        }

        // 2. Check if the user's role matches the required role
        if (Auth::user()->role !== $role) {
            
            // Redirect based on what their actual role is
            return match (Auth::user()->role) {
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