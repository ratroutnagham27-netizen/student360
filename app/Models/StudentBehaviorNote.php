<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentBehaviorNote extends Model
{
    /** Table has only created_at (no updated_at). */
    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'teacher_id',
        'category',
        'note',
    ];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}