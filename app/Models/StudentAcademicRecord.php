<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentAcademicRecord extends Model
{
    /** Table has only created_at (no updated_at). */
    public $timestamps = false;

    protected $fillable = [
        'student_id',
        'subject',
        'term',
        'score',
    ];

    protected $casts = [
        'score'      => 'decimal:2',
        'created_at' => 'datetime',
    ];

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }
}