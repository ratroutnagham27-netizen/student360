<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Student;
use App\Models\TeacherUpdate;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TeacherUpdateController extends Controller
{
    public function create(): View
{
    $students = \App\Models\Student::orderBy('name')->get();
    
    return view('teacher-updates.create', compact('students'));
}

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'student_id' => ['required', 'integer', 'exists:students,id'],
            'category'   => ['required', 'string', 'in:academic,behavioral,personal'],
            'note'       => ['required', 'string', 'max:2000'],
        ]);

        if (! $request->user()->canUpdateStudent($validated['student_id'])) {
            abort(403, 'You are not authorized to add updates for this student.');
        }

        $teacherUpdate = TeacherUpdate::create([
    'student_id'         => $validated['student_id'],
    'teacher_id'         => $request->user()->id,
    'category'           => $validated['category'],
    'note'               => $validated['note'],
    'visible_to_parent'  => $request->boolean('visible_to_parent'),
]);

        AuditLog::create([
            'user_id'        => $request->user()->id,
            'auditable_type' => TeacherUpdate::class,
            'auditable_id'   => $teacherUpdate->id,
            'field'          => 'note',
            'old_value'      => null,
            'new_value'      => $teacherUpdate->note,
        ]);

        return back()->with('status', 'Update added successfully.');
    }

    public function index(Student $student): JsonResponse
    {
        if (! request()->user()->canViewStudent($student->id)) {
            abort(403, 'You are not authorized to view updates for this student.');
        }

        $updates = $student->teacherUpdates()
            ->where('visible_to_parent', true)
            ->latest()
            ->get(['id', 'student_id', 'teacher_id', 'category', 'note', 'created_at']);

        return response()->json($updates);
    }
}