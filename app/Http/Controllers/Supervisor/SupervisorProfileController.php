<?php

namespace App\Http\Controllers\Supervisor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\Supervisor;

class SupervisorProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('supervisor.manageprofile', compact('user'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $supervisor = Supervisor::where('user_id', $user->id)->first();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        try {
            DB::beginTransaction();

            // Update core user record
            $user->update([
                'name'  => $request->name,
                'email' => $request->email,
            ]);

            // Mirror changes into supervisors table if record exists
            if ($supervisor) {
                $supervisor->update([
                    'name'  => $request->name,
                    'email' => $request->email,
                ]);
            }

            DB::commit();
            return back()->with('success', 'Profile updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update profile. Please try again.');
        }
    }

    public function updatePassword(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $supervisor = Supervisor::where('user_id', $user->id)->first();

        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()->symbols()],
        ]);

        try {
            DB::beginTransaction();

            $hashed = Hash::make($request->password);

            // Update core user password
            $user->update([
                'password' => $hashed,
            ]);

            // Keep supervisors table in sync if there is a password column
            if ($supervisor) {
                $supervisor->update([
                    'password' => $hashed,
                ]);
            }

            DB::commit();
            return back()->with('success', 'Password updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update password. Please try again.');
        }
    }
}

