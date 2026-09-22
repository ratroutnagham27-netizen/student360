<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends Model
{
    /** Table has only created_at (no updated_at). */
    public $timestamps = false;

    protected $fillable = [
        'name',
        'date_of_birth',
        'class_name',
        'parent_id',
    ];

    protected $casts = [
        'date_of_birth' => 'date',
        'created_at'    => 'datetime',
    ];

    public function parent(): BelongsTo
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function academicRecords(): HasMany
    {
        return $this->hasMany(StudentAcademicRecord::class);
    }

    public function behaviorNotes(): HasMany
    {
        return $this->hasMany(StudentBehaviorNote::class);
    }
}