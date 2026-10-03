<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ParentStudentAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_parent_can_view_own_student(): void
    {
        $parent = User::factory()->create([
            'role' => UserRole::PARENT,
        ]);

        $studentId = DB::table('students')->insertGetId([
            'name' => 'Child Student',
            'date_of_birth' => '2015-01-01',
            'class_name' => 'Grade 5',
            'parent_id' => $parent->id,
        ]);

        $this->assertTrue(
            $parent->canViewStudent($studentId)
        );
    }

    public function test_parent_cannot_view_another_parents_student(): void
    {
        $parent = User::factory()->create([
            'role' => UserRole::PARENT,
        ]);

        $otherParent = User::factory()->create([
            'role' => UserRole::PARENT,
        ]);

        $studentId = DB::table('students')->insertGetId([
            'name' => 'Other Child',
            'date_of_birth' => '2015-01-01',
            'class_name' => 'Grade 5',
            'parent_id' => $otherParent->id,
        ]);

        $this->assertFalse(
            $parent->canViewStudent($studentId)
        );
    }

    public function test_teacher_cannot_use_parent_student_access(): void
    {
        $teacher = User::factory()->create([
            'role' => UserRole::TEACHER,
        ]);

        $studentId = DB::table('students')->insertGetId([
            'name' => 'Child Student',
            'date_of_birth' => '2015-01-01',
            'class_name' => 'Grade 5',
            'parent_id' => $teacher->id,
        ]);

        $this->assertFalse(
            $teacher->canViewStudent($studentId)
        );
    }

    public function test_nonexistent_student_cannot_be_viewed(): void
    {
        $parent = User::factory()->create([
            'role' => UserRole::PARENT,
        ]);

        $this->assertFalse(
            $parent->canViewStudent(999999)
        );
    }
}