<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SystemSetting;
use Illuminate\Http\Request;

class AdminSettingController extends Controller
{
    /**
     * Show the page to set IPs that auto-approve trainee clock-in (company network).
     * Same function as before: uses SystemSetting::get/set('company_clock_in_ips').
     */
    public function companyNetworkIps()
    {
        $ips = SystemSetting::get('company_clock_in_ips', '');

        return view('admin.settings.company_network_ips', [
            'companyClockInIps' => $ips,
        ]);
    }

    /**
     * Update company network IPs for auto-approve (trainee clock-in on company WiFi).
     * Value: comma-separated IPs or prefixes, e.g. "192.168.1.,10.0.0."
     */
    public function updateCompanyNetworkIps(Request $request)
    {
        $validated = $request->validate([
            'ips' => ['nullable', 'string', 'max:500'],
        ]);
        $value = trim($validated['ips'] ?? '');
        SystemSetting::set('company_clock_in_ips', $value);

        return redirect()
            ->route('admin.settings.companyNetworkIps')
            ->with('success', 'Auto-approve IPs updated. Trainee clock-in from these IPs will be auto-approved.');
    }
}
