<?php

namespace App\Http\Controllers;

use App\Models\Student;
use App\Models\TeacherUpdate;
use Illuminate\Support\Facades\Auth;

class ParentDashboardController extends Controller
{
    public function show()
    {
        $parent = Auth::user();

        // Parent's children (V1: assume one child)
        $children = Student::query()
            ->where('parent_id', $parent->id)
            ->with('teacherUpdates.teacher')
            ->get();

        $student = $children->first();

        // Only visible updates, newest first
        $updates = $student
            ? TeacherUpdate::with('teacher')
                ->where('student_id', $student->id)
                ->where('visible_to_parent', true)
                ->latest()
                ->get()
            : collect();

        // Count visible teacher notes for the stat card
        $visibleCount = $updates->count();

        return view('dashboards.parent', [
            'parent'       => $parent,
            'student'      => $student,
            'children'     => $children,
            'updates'      => $updates,
            'visibleCount' => $visibleCount,
        ]);
    }
}