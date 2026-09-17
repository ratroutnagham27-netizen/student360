<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentProfile extends Model
{
    protected $fillable = [
        'name',
        'date_of_birth',
        'class_name',
        'parent_id',
        'subject',
        'term',
        'score',
        'category',
        'behavior_note',
        'teacher_id',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'score'         => 'decimal:2',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }
}