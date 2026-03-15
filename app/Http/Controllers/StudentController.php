<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\AcademicYear;
use App\Models\Setting;
use App\Services\NectaGrading;

class StudentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $classId = $request->query('school_class_id');
        $query = Student::with(['schoolClass', 'academicYear']);
        
        if ($classId) {
            $query->where('school_class_id', '=', $classId);
        }

        $students = $query->get();
        $classes = SchoolClass::all();
        
        $selectedClass = $classId ? SchoolClass::find($classId) : null;
        $isNecta = $selectedClass ? NectaGrading::isNectaClass($selectedClass->class_name) : false;

        return view('students.index', compact('students', 'classes', 'selectedClass', 'isNecta'));
    }

    public function create()
    {
        $classes = SchoolClass::all();
        $years = AcademicYear::all();
        $schoolNumber = Setting::get('school_number', 'S0000');
        return view('students.create', compact('classes', 'years', 'schoolNumber'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'admission_number' => 'required|string|max:255',
            'name' => 'required|string|max:255',
            'gender' => 'required|in:Male,Female',
            'school_class_id' => 'required|exists:school_classes,id',
            'academic_year_id' => 'required|exists:academic_years,id',
        ]);

        $existing = Student::where('admission_number', '=', $request->admission_number)->first();

        if ($existing && !$request->has('confirm_move')) {
            return redirect()->back()
                ->withInput()
                ->with('move_warning', [
                    'message' => "Student {$existing->name} (Adm: {$existing->admission_number}) is already registered in {$existing->schoolClass->class_name}. Do you want to move them to the new class?",
                    'admission_number' => $existing->admission_number
                ]);
        }

        if ($existing && $request->has('confirm_move')) {
            $existing->update([
                'name' => $request->name,
                'gender' => $request->gender,
                'school_class_id' => $request->school_class_id,
                'academic_year_id' => $request->academic_year_id,
            ]);
            return redirect()->route('students.index')->with('success', 'Student moved successfully!');
        }

        // Final check for uniqueness if not moving
        $request->validate([
            'admission_number' => 'unique:students,admission_number'
        ]);

        Student::create($request->all());

        return redirect()->route('students.index')->with('success', 'Student registered successfully!');
    }

    /**
     * Generate NECTA Registration Numbers for a class (Form 2/4 only).
     */
    public function generateNectaNumbers(Request $request)
    {
        $request->validate([
            'school_class_id' => 'required|exists:school_classes,id',
        ]);

        $class = SchoolClass::findOrFail($request->school_class_id);

        if (!NectaGrading::isNectaClass($class->class_name)) {
            return redirect()->back()->with('error', 'NECTA registration numbers are only for Form 2 and Form 4.');
        }

        $students = Student::where('school_class_id', '=', $class->id)
            ->orderBy('name', 'asc') // Alphabetical sorting (First Name to Surname)
            ->get();

        $schoolNumber = Setting::get('school_number', 'S0000');
        $year = date('Y'); // Default to current year

        foreach ($students as $index => $student) {
            $studentNumber = str_pad($index + 1, 4, '0', STR_PAD_LEFT);
            $regNumber = "{$schoolNumber}/{$studentNumber}/{$year}";
            $student->update(['registration_number' => $regNumber]);
        }

        return redirect()->back()->with('success', "Succesfully generated NECTA registration numbers for {$students->count()} students in {$class->class_name}.");
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        //
    }

    public function update(\Illuminate\Http\Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        $student = Student::findOrFail($id);
        $student->delete();

        return redirect()->route('students.index')->with('success', 'Student deleted successfully!');
    }
}
