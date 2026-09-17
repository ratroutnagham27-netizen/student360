<?php

namespace App\Observers;

use App\Models\AuditLog;
use App\Models\Student;

class StudentObserver
{
    public function created(Student $student): void
    {
        if (!auth()->check()) {
            return;
        }

        AuditLog::create([
            'user_id' => auth()->id(),
            'auditable_type' => 'Student',
            'auditable_id' => $student->id,
            'field' => 'record',
            'old_value' => null,
            'new_value' => 'created',
        ]);
    }

    public function updated(Student $student): void
    {
        if (!auth()->check()) {
            return;
        }

        foreach ($student->getChanges() as $field => $newValue) {
            if ($field === 'updated_at') {
                continue;
            }

            AuditLog::create([
                'user_id' => auth()->id(),
                'auditable_type' => 'Student',
                'auditable_id' => $student->id,
                'field' => $field,
                'old_value' => $student->getOriginal($field),
                'new_value' => $newValue,
            ]);
        }
    }

    public function deleted(Student $student): void
    {
        if (!auth()->check()) {
            return;
        }

        AuditLog::create([
            'user_id' => auth()->id(),
            'auditable_type' => 'Student',
            'auditable_id' => $student->id,
            'field' => 'record',
            'old_value' => 'existed',
            'new_value' => 'deleted',
        ]);
    }

    public function restored(Student $student): void
    {
        //
    }

    public function forceDeleted(Student $student): void
    {
        //
    }
}