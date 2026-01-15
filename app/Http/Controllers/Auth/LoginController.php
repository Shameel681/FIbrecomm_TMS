<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle the login attempt using a single users table
     */
    public function login(Request $request)
    {
        // 1. Validate the input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Attempt login using the default 'web' guard
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            // 3. Get the authenticated user
            $user = Auth::user();

            // 4. Redirect based on role
            switch ($user->role) {
                case 'admin':
                    return redirect()->intended('/admin/users');
                case 'hr':
                    return redirect()->intended('/hr/dashboard');
                case 'supervisor':
                    return redirect()->intended('/supervisor/dashboard');
                case 'trainee':
                    return redirect()->intended('/trainee/dashboard');
                default:
                    return redirect()->intended('/');
            }
        }

        // 5. If attempt fails, go back with error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Handle Logout
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}