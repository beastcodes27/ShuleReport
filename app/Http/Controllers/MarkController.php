<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MarkController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(\Illuminate\Http\Request $request)
    {
        $assignment_id = $request->query('assignment_id');
        
        if (!$assignment_id) {
            $teacherAssignments = \App\Models\TeacherSubject::where('user_id', '=', auth()->id())->get();
            
            if ($teacherAssignments->isEmpty()) {
                return redirect()->route('teacher.dashboard')->with('error', 'You have no assigned classes yet.');
            }

            // Fetch marks for all assignments of this teacher
            $marks = \App\Models\Mark::with(['student', 'student.schoolClass', 'subject'])
                ->where(function($query) use ($teacherAssignments) {
                    foreach($teacherAssignments as $ta) {
                        $query->orWhere(function($q) use ($ta) {
                            $q->where('subject_id', '=', $ta->subject_id)
                              ->whereHas('student', function($sq) use ($ta) {
                                  $sq->where('school_class_id', '=', $ta->school_class_id);
                              });
                        });
                    }
                })
                ->orderBy('created_at', 'desc')
                ->get();

            return view('marks.index_all', compact('marks'));
        }

        $assignment = \App\Models\TeacherSubject::with(['schoolClass', 'subject'])->findOrFail($assignment_id);
        
        $marks = \App\Models\Mark::with(['student'])
            ->where('subject_id', '=', $assignment->subject_id)
            ->whereHas('student', function($q) use ($assignment) {
                $q->where('school_class_id', '=', $assignment->school_class_id);
            })
            ->get();

        return view('marks.index', compact('marks', 'assignment'));
    }

    public function create(\Illuminate\Http\Request $request)
    {
        $assignment_id = $request->query('assignment_id');
        $assignment = \App\Models\TeacherSubject::with(['schoolClass', 'subject'])->findOrFail($assignment_id);
        
        $students = \App\Models\Student::where('school_class_id', $assignment->school_class_id)->get();
        $academicYear = \App\Models\AcademicYear::where('is_active', true)->first();

        return view('marks.create', compact('students', 'assignment', 'academicYear'));
    }

    public function store(\Illuminate\Http\Request $request)
    {
        $request->validate([
            'assignment_id' => 'required|exists:teacher_subjects,id',
            'semester' => 'required|integer|min:1|max:2',
            'marks' => 'required|array',
            'marks.*' => 'nullable|numeric|min:0|max:100',
        ]);

        $assignment = \App\Models\TeacherSubject::findOrFail($request->assignment_id);
        $academicYear = \App\Models\AcademicYear::where('is_active', true)->first();

        if (!$academicYear) {
            return back()->withErrors(['academic_year' => 'No active academic year found.']);
        }

        foreach ($request->marks as $student_id => $score) {
            if (!is_null($score)) {
                \App\Models\Mark::updateOrCreate(
                    [
                        'student_id' => $student_id,
                        'subject_id' => $assignment->subject_id,
                        'academic_year_id' => $academicYear->id,
                        'semester' => $request->semester,
                    ],
                    ['score' => $score]
                );
            }
        }

        return redirect()->route('teacher.dashboard')->with('success', 'Marks saved successfully!');
    }

    public function show(string $id)
    {
        //
    }

    public function edit(string $id)
    {
        $mark = \App\Models\Mark::with(['student', 'subject', 'academicYear'])->findOrFail($id);
        return view('marks.edit', compact('mark'));
    }

    public function update(\Illuminate\Http\Request $request, string $id)
    {
        $request->validate([
            'score' => 'required|numeric|min:0|max:100',
        ]);

        $mark = \App\Models\Mark::findOrFail($id);
        $mark->update([
            'score' => $request->score
        ]);

        // Find the assignment to know where to redirect back
        $assignment = \App\Models\TeacherSubject::where('school_class_id', '=', $mark->student->school_class_id)
            ->where('subject_id', '=', $mark->subject_id)
            ->where('user_id', '=', auth()->id())
            ->first();

        $redirect = $assignment 
            ? route('marks.index', ['assignment_id' => $assignment->id])
            : route('teacher.dashboard');

        return redirect($redirect)->with('success', 'Mark updated successfully!');
    }

    public function destroy(string $id)
    {
        $mark = \App\Models\Mark::findOrFail($id);
        $mark->delete();

        return back()->with('success', 'Mark deleted successfully!');
    }
}
