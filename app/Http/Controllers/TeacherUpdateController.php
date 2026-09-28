<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\TeacherUpdate;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class TeacherUpdateController extends Controller
{
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
            'student_id' => $validated['student_id'],
            'teacher_id' => $request->user()->id,
            'category'   => $validated['category'],
            'note'       => $validated['note'],
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
}