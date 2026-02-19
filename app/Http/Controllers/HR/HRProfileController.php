<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\HR as HRModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;

class HRProfileController extends Controller
{
    public function edit()
    {
        $user = Auth::user();
        return view('hr.manageprofile', compact('user'));
    }

    public function update(Request $request)
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $hr = HRModel::where('user_id', $user->id)->first();

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        ]);

        try {
            DB::beginTransaction();

            $user->update([
                'name'  => $request->name,
                'email' => $request->email,
            ]);

            if ($hr) {
                $hr->update([
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
        $hr = HRModel::where('user_id', $user->id)->first();

        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password' => ['required', 'confirmed', Password::min(8)->letters()->numbers()->symbols()],
        ]);

        try {
            DB::beginTransaction();

            $hashed = Hash::make($request->password);
            $user->update(['password' => $hashed]);

            if ($hr && in_array('password', $hr->getFillable())) {
                $hr->update(['password' => $hashed]);
            }

            DB::commit();
            return back()->with('success', 'Password updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Failed to update password. Please try again.');
        }
    }
}
