<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\TeacherUpdate;
use Illuminate\Support\Facades\Auth;

class StudentProfileController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        // ============ PARENT ============
        if ($user->isParent()) {
            $student = Student::with('parent')
                ->where('parent_id', $user->id)
                ->first();

            if (! $student) {
                abort(403, 'No student is linked to your account.');
            }

            $teacherUpdates = TeacherUpdate::with('teacher')
                ->where('student_id', $student->id)
                ->where('visible_to_parent', true)
                ->latest()
                ->get();
        }
        // ============ TEACHER / ADMIN ============
        else {
            $student = Student::with('parent')->first();

            $teacherUpdates = $student
                ? TeacherUpdate::with('teacher')
                    ->where('student_id', $student->id)
                    ->latest()
                    ->get()
                : collect();
        }

        $academicRecordsByTerm = $student
            ? $student->academicRecords()
                ->orderBy('term')
                ->orderBy('subject')
                ->get()
                ->groupBy('term')
            : collect();

        $academicAveragesByTerm = $academicRecordsByTerm->map(
            fn ($records) => round($records->avg('score'), 2)
        );

        return view('student-profile', [
            'student' => $student,
            'teacherUpdates' => $teacherUpdates,
            'academicRecordsByTerm' => $academicRecordsByTerm,
            'academicAveragesByTerm' => $academicAveragesByTerm,
        ]);
    }
}