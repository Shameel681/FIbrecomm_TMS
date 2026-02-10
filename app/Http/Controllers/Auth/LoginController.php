<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

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

            // 3a. If trainee internship has ended, auto-deactivate and block login with clear message
            if ($user->role === 'trainee' && $user->trainee) {
                $trainee = $user->trainee;
                if ($trainee->end_date && Carbon::now()->greaterThan(Carbon::parse($trainee->end_date)->endOfDay())) {
                    // Auto mark as completed & deactivate account
                    $user->is_active = false;
                    $user->save();
                    $trainee->status = 'completed';
                    $trainee->save();

                    Auth::logout();
                    $request->session()->invalidate();
                    $request->session()->regenerateToken();

                    return back()->withErrors([
                        'email' => 'Your internship duration has ended and your trainee account has been deactivated. Please contact HR if you need further assistance.',
                    ])->onlyInput('email');
                }
            }

            // 4. Check if account is active
            if (!$user->is_active) {
                Auth::logout();
                $request->session()->invalidate();
                $request->session()->regenerateToken();
                
                return back()->withErrors([
                    'email' => 'Your account has been deactivated. Please contact HR for assistance.',
                ])->onlyInput('email');
            }

            // 5. Redirect based on role
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