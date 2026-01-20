<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Auth;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // Define aliases for your custom middleware
        $middleware->alias([
            'multi.guest' => \App\Http\Middleware\MultiGuest::class,
            'role'        => \App\Http\Middleware\CheckRole::class,
            'no.cache'    => \App\Http\Middleware\PreventBackHistory::class, 
        ]);

        /**
         * SYSTEM INTEGRITY: Redirect Authenticated Users
         * If an authenticated user tries to access guest routes (like /login),
         * this logic determines where they should be sent based on their role.
         */
        $middleware->redirectUsersTo(function () {
            if (!Auth::check()) {
                return route('/');
            }

            $role = Auth::user()->role;

            return match($role) {
                'admin'      => route('admin.users.index'),
                'hr'         => route('hr.dashboard'),
                'supervisor' => route('supervisor.dashboard'),
                'trainee'    => route('trainee.dashboard'),
                default      => route('/'),
            };
        });
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();