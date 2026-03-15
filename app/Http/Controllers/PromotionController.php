<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PromotionController extends Controller
{
    public function index()
    {
        $classes = \App\Models\SchoolClass::all();
        $years = \App\Models\AcademicYear::all();
        
        return view('master.promotions.index', compact('classes', 'years'));
    }

    public function promote(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'from_year_id' => 'required|exists:academic_years,id',
            'from_class_id' => 'required|exists:school_classes,id',
            'to_year_id' => 'required|exists:academic_years,id|different:from_year_id',
            'to_class_id' => 'required|exists:school_classes,id',
        ]);

        $affected = \App\Models\Student::where('academic_year_id', $request->from_year_id)
            ->where('school_class_id', $request->from_class_id)
            ->update([
                'academic_year_id' => $request->to_year_id,
                'school_class_id' => $request->to_class_id
            ]);

        if ($affected > 0) {
            return redirect()->back()->with('success', "Successfully promoted {$affected} students!");
        }

        return redirect()->back()->with('error', 'No students found matching the selected criteria. Nothing was changed.');
    }
}
