<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $schoolName = Setting::get('school_name', config('app.name'));
        $schoolNumber = Setting::get('school_number', 'S0101');
        $district = Setting::get('district', '');
        $region = Setting::get('region', '');
        $reportTemplate = Setting::get('report_template', 'standard');

        return view('settings.index', compact(
            'schoolName', 'schoolNumber', 'district', 'region', 'reportTemplate'
        ));
    }

    public function update(Request $request)
    {
        $request->validate([
            'school_name' => 'required|string|max:255',
            'school_number' => 'required|string|max:20',
            'district' => 'nullable|string|max:255',
            'region' => 'nullable|string|max:255',
            'report_template' => 'required|string|in:standard,elegant,professional',
        ]);

        Setting::set('school_name', $request->school_name);
        Setting::set('school_number', $request->school_number);
        Setting::set('district', $request->district);
        Setting::set('region', $request->region);
        Setting::set('report_template', $request->report_template);

        // Also update school_center_number for the ID generator logic if changed
        Setting::set('school_center_number', $request->school_number);

        return redirect()->back()->with('success', 'Settings updated successfully!');
    }
}
