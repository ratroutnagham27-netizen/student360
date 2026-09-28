<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\TeacherUpdate;

class StudentProfileController extends Controller
{
    public function show()
    {
        // Sprint 3 demo: show the first student.
        // Future: use route parameter /students/{student}/profile
        $student = Student::with('parent')->firstOrFail();

        $teacherUpdates = TeacherUpdate::with('teacher')
            ->where('student_id', $student->id)
            ->latest()
            ->get();

        return view('student-profile', [
            'student'        => $student,
            'teacherUpdates' => $teacherUpdates,
        ]);
    }
}