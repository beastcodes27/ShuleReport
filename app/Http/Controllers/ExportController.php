<?php

namespace App\Http\Controllers;

use App\Models\Mark;
use App\Models\Student;
use App\Models\SchoolClass;
use App\Models\AcademicYear;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ExportController extends Controller
{
    /**
     * Export full class results for Academics.
     */
    public function exportClassResults(Request $request)
    {
        $classId = $request->query('class_id');
        $yearId = $request->query('year_id');
        $semester = $request->query('semester', 1);

        if (!$classId || !$yearId) {
            return back()->with('error', 'Please select class and year to export.');
        }

        $class = SchoolClass::findOrFail($classId);
        $year = AcademicYear::findOrFail($yearId);

        $students = Student::where('school_class_id', '=', $classId)
            ->where('academic_year_id', '=', $yearId)
            ->get();

        $filename = "Results_{$class->class_name}_Semester_{$semester}_{$year->year_name}.csv";

        return new StreamedResponse(function () use ($students, $yearId, $semester) {
            $handle = fopen('php://output', 'w');
            
            // CSV Header
            fputcsv($handle, ['Student Name', 'Admission No', 'Total Marks', 'Average', 'Grade']);

            foreach ($students as $student) {
                $marks = Mark::where('student_id', '=', $student->id)
                    ->where('academic_year_id', '=', $yearId)
                    ->where('semester', '=', $semester)
                    ->get();

                $total = $marks->sum('score');
                $count = $marks->count();
                $average = $count > 0 ? number_format($total / $count, 2) : 0;
                
                // Simple grade calc for CSV (Internal pattern)
                $g = 'F';
                if($average >= 80) $g = 'A'; elseif($average >= 60) $g = 'B'; elseif($average >= 40) $g = 'C'; elseif($average >= 30) $g = 'D';

                fputcsv($handle, [
                    $student->name,
                    $student->admission_number,
                    $total,
                    $average,
                    $g
                ]);
            }

            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }

    /**
     * Export subject results for Academics or Teachers.
     */
    public function exportSubjectResults(Request $request)
    {
        $classId = $request->query('class_id');
        $subjectId = $request->query('subject_id');
        $yearId = $request->query('year_id');
        $semester = $request->query('semester', 1);

        if (!$classId || !$subjectId || !$yearId) {
            // Try to get from TeacherSubject assignment if coming from teacher dashboard
            $assignmentId = $request->query('assignment_id');
            if ($assignmentId) {
                $assignment = \App\Models\TeacherSubject::findOrFail($assignmentId);
                $classId = $assignment->school_class_id;
                $subjectId = $assignment->subject_id;
                // Academic year usually defaults to active if not provided
                if (!$yearId) {
                    $year = AcademicYear::where('is_active', '=', true)->first();
                    $yearId = $year->id;
                }
            } else {
                return back()->with('error', 'Missing required parameters for export.');
            }
        }

        $class = SchoolClass::findOrFail($classId);
        $subject = \App\Models\Subject::findOrFail($subjectId);
        $year = AcademicYear::findOrFail($yearId);

        $marks = Mark::with('student')
            ->where('subject_id', '=', $subjectId)
            ->where('academic_year_id', '=', $yearId)
            ->where('semester', '=', $semester)
            ->whereHas('student', function($q) use ($classId) {
                $q->where('school_class_id', '=', $classId);
            })
            ->get();

        $filename = "Marks_{$subject->subject_name}_{$class->class_name}_S{$semester}.csv";

        return new StreamedResponse(function () use ($marks) {
            $handle = fopen('php://output', 'w');
            
            fputcsv($handle, ['Student Name', 'Admission No', 'Score', 'Grade', 'Remarks']);

            foreach ($marks as $mark) {
                $s = $mark->score;
                $g = 'F';
                if($s >= 80) $g = 'A'; elseif($s >= 60) $g = 'B'; elseif($s >= 40) $g = 'C'; elseif($s >= 30) $g = 'D';
                $r = ($g == 'F') ? 'Fail' : 'Pass';

                fputcsv($handle, [
                    $mark->student->name,
                    $mark->student->admission_number,
                    $s,
                    $g,
                    $r
                ]);
            }

            fclose($handle);
        }, 200, [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
        ]);
    }
}
