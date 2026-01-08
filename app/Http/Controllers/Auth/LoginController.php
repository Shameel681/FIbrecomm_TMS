<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Handle the login attempt
     */
    public function login(Request $request)
    {
        // 1. Validate the input
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        // 2. Try HR Guard
        if (Auth::guard('hr')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/hr/dashboard');
        }

        // 3. Try Supervisor Guard
        if (Auth::guard('supervisor')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/supervisor/dashboard');
        }

        // 4. Try Trainee Guard
        if (Auth::guard('trainee')->attempt($credentials)) {
            $request->session()->regenerate();
            return redirect()->intended('/trainee/dashboard');
        }

        // 5. If all fail, go back with error
        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    /**
     * Handle Logout for all guards
     */
    public function logout(Request $request)
    {
        Auth::guard('hr')->logout();
        Auth::guard('supervisor')->logout();
        Auth::guard('trainee')->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }
}