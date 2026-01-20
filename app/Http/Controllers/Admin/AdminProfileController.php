<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rules\Password;


class AdminProfileController extends Controller
{
    public function edit()
    {
        return view('admin.manageprofile');
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        try {
            DB::beginTransaction();
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
            ]);
            DB::commit();
            return redirect()->back()->with('success', 'Identity details updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Critical error: Failed to update identity.');
        }
    }

    public function updatePassword(Request $request)
{
    // Define the $user variable locally to fix the error in image_4d5ccf.png
    /** @var \App\Models\User $user */
    $user = Auth::user(); 

    $request->validate([
        'current_password' => ['required', 'current_password'],
        'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()->symbols()],
    ]);

    try {
        DB::beginTransaction();
        
        // Now the system knows what $user is
        $user->update([
            'password' => Hash::make($request->password),
        ]);

        DB::commit();
        return redirect()->back()->with('success', 'Security key rotated successfully.');
    } catch (\Exception $e) {
        DB::rollBack();
        return redirect()->back()->with('error', 'Protocol failure: Password rotation failed.');
    }
}

    public function emergencyExit(Request $request)
{
    /** @var \App\Models\User $user */
    $user = Auth::user();

    $request->validate([
        'current_password' => ['required', 'current_password'],
    ]);

    // This kills all other sessions across different devices
    Auth::logoutOtherDevices($request->current_password);

    // This kills the current session
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/login')->with('success', 'SYSTEM LOCKDOWN: All active sessions terminated.');
}
}