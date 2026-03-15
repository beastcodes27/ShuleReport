<?php

namespace App\Http\Controllers;

use App\Models\GradeSetting;
use Illuminate\Http\Request;

class GradeSettingController extends Controller
{
    public function index()
    {
        $grades = GradeSetting::orderByDesc('min_score')->get();
        return view('master.grade_settings.index', compact('grades'));
    }

    public function create()
    {
        return view('master.grade_settings.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'grade'     => 'required|string|max:2',
            'division'  => 'required|string|max:50',
            'min_score' => 'required|integer|min:0|max:100',
            'max_score' => 'required|integer|min:0|max:100|gte:min_score',
            'remarks'   => 'required|string|max:100',
        ]);

        GradeSetting::create($request->only(['grade', 'division', 'min_score', 'max_score', 'remarks']));

        return redirect()->route('grade-settings.index')->with('success', 'Grade interval added successfully!');
    }

    public function edit(GradeSetting $gradeSetting)
    {
        return view('master.grade_settings.edit', compact('gradeSetting'));
    }

    public function update(Request $request, GradeSetting $gradeSetting)
    {
        $request->validate([
            'grade'     => 'required|string|max:2',
            'division'  => 'required|string|max:50',
            'min_score' => 'required|integer|min:0|max:100',
            'max_score' => 'required|integer|min:0|max:100|gte:min_score',
            'remarks'   => 'required|string|max:100',
        ]);

        $gradeSetting->update($request->only(['grade', 'division', 'min_score', 'max_score', 'remarks']));

        return redirect()->route('grade-settings.index')->with('success', 'Grade interval updated successfully!');
    }

    public function destroy(GradeSetting $gradeSetting)
    {
        $gradeSetting->delete();
        return redirect()->route('grade-settings.index')->with('success', 'Grade interval deleted.');
    }
}
