<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TeacherUpdate extends Model
{
    protected $fillable = [
        'student_id',
        'teacher_id',
        'category',
        'note',
        'visible_to_parent',
    ];

    protected $casts = [
    'visible_to_parent' => 'boolean',
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