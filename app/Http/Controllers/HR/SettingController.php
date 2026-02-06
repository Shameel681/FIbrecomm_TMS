<?php

namespace App\Http\Controllers\HR;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    /**
     * Show simple form for HR to manage global allowance rate.
     */
    public function editAllowance()
    {
        $rate = (float) SystemSetting::get('allowance_rate_per_day', 30);

        return view('hr.settings.allowance', [
            'rate' => $rate,
        ]);
    }

    /**
     * Update global allowance rate (per approved working day).
     */
    public function updateAllowance(Request $request)
    {
        $validated = $request->validate([
            'rate' => ['required', 'numeric', 'min:0'],
        ]);

        SystemSetting::set('allowance_rate_per_day', $validated['rate']);

        return redirect()
            ->route('hr.settings.allowance.edit')
            ->with('success', 'Allowance rate has been updated.');
    }
}

