<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AcademicYearController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $years = \App\Models\AcademicYear::all();
        return view('academic_years.index', compact('years'));
    }

    public function create()
    {
        return view('academic_years.create');
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'year_name' => 'required|string|unique:academic_years|max:255',
            'is_active' => 'boolean'
        ]);

        if ($request->has('is_active') && $request->is_active) {
            \App\Models\AcademicYear::where('is_active', true)->update(['is_active' => false]);
        }

        \App\Models\AcademicYear::create([
            'year_name' => $request->year_name,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('academic-years.index')->with('success', 'Academic Year added successfully!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $year = \App\Models\AcademicYear::findOrFail($id);
        return view('academic_years.edit', compact('year'));
    }

    public function update(\Illuminate\Http\Request $request, string $id)
    {
        $request->validate([
            'year_name' => 'required|string|max:255|unique:academic_years,year_name,' . $id,
            'is_active' => 'boolean'
        ]);

        $year = \App\Models\AcademicYear::findOrFail($id);

        if ($request->has('is_active') && $request->is_active) {
            \App\Models\AcademicYear::where('is_active', true)->update(['is_active' => false]);
        }

        $year->update([
            'year_name' => $request->year_name,
            'is_active' => $request->has('is_active')
        ]);

        return redirect()->route('academic-years.index')->with('success', 'Academic Year updated successfully!');
    }

    public function destroy(string $id)
    {
        $year = \App\Models\AcademicYear::findOrFail($id);
        $year->delete();

        return redirect()->route('academic-years.index')->with('success', 'Academic Year deleted successfully!');
    }
}
