<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class TeacherUpdatePermissionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_only_assigned_teacher_can_update_student(): void
    {
        $teacher = User::factory()->create([
            'role' => UserRole::TEACHER,
        ]);

        $otherTeacher = User::factory()->create([
            'role' => UserRole::TEACHER,
        ]);

        $parent = User::factory()->create([
            'role' => UserRole::PARENT,
        ]);

        $admin = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $studentId = DB::table('students')->insertGetId([
            'name' => 'Demo Student',
            'date_of_birth' => '2015-01-01',
            'class_name' => 'Grade 5',
            'parent_id' => $parent->id,
            'homeroom_teacher_id' => $teacher->id,
        ]);

        // Only the assigned teacher is allowed.
        $this->assertTrue($teacher->canUpdateStudent($studentId));
        $this->assertFalse($otherTeacher->canUpdateStudent($studentId));
        $this->assertFalse($parent->canUpdateStudent($studentId));
        $this->assertFalse($admin->canUpdateStudent($studentId));

        // Reassigning the student changes who is allowed.
        DB::table('students')->where('id', $studentId)->update([
            'homeroom_teacher_id' => $otherTeacher->id,
        ]);

        $this->assertFalse($teacher->canUpdateStudent($studentId));
        $this->assertTrue($otherTeacher->canUpdateStudent($studentId));

        // A student without an assigned teacher is not allowed.
        DB::table('students')->where('id', $studentId)->update([
            'homeroom_teacher_id' => null,
        ]);

        $this->assertFalse($teacher->canUpdateStudent($studentId));

        // A nonexistent student is not allowed.
        DB::table('students')->where('id', $studentId)->delete();

        $this->assertFalse($teacher->canUpdateStudent($studentId));
    }
}