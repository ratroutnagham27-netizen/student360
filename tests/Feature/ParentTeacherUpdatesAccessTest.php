<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class ParentTeacherUpdatesAccessTest extends TestCase
{
    use RefreshDatabase;

    public function test_parent_can_view_visible_update_for_own_student(): void
    {
        $parent = User::factory()->create([
            'role' => UserRole::PARENT,
        ]);

        $teacher = User::factory()->create([
            'role' => UserRole::TEACHER,
        ]);

        $studentId = DB::table('students')->insertGetId([
            'name' => 'Child Student',
            'date_of_birth' => '2015-01-01',
            'class_name' => 'Grade 5',
            'parent_id' => $parent->id,
        ]);

        $updateId = DB::table('teacher_updates')->insertGetId([
            'student_id' => $studentId,
            'teacher_id' => $teacher->id,
            'category' => 'Academic',
            'note' => 'Good progress in mathematics.',
            'visible_to_parent' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $update = DB::table('teacher_updates')
            ->where('id', $updateId)
            ->where('student_id', $studentId)
            ->where('visible_to_parent', true)
            ->first();

        $this->assertNotNull($update);
        $this->assertEquals($studentId, $update->student_id);
    }

    public function test_parent_cannot_view_hidden_update_for_own_student(): void
    {
        $parent = User::factory()->create([
            'role' => UserRole::PARENT,
        ]);

        $teacher = User::factory()->create([
            'role' => UserRole::TEACHER,
        ]);

        $studentId = DB::table('students')->insertGetId([
            'name' => 'Child Student',
            'date_of_birth' => '2015-01-01',
            'class_name' => 'Grade 5',
            'parent_id' => $parent->id,
        ]);

        $updateId = DB::table('teacher_updates')->insertGetId([
            'student_id' => $studentId,
            'teacher_id' => $teacher->id,
            'category' => 'Behavior',
            'note' => 'Private teacher note.',
            'visible_to_parent' => false,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $update = DB::table('teacher_updates')
            ->where('id', $updateId)
            ->where('student_id', $studentId)
            ->where('visible_to_parent', true)
            ->first();

        $this->assertNull($update);
    }

    public function test_parent_cannot_view_update_for_another_parents_student(): void
    {
        $parent = User::factory()->create([
            'role' => UserRole::PARENT,
        ]);

        $otherParent = User::factory()->create([
            'role' => UserRole::PARENT,
        ]);

        $teacher = User::factory()->create([
            'role' => UserRole::TEACHER,
        ]);

        $otherStudentId = DB::table('students')->insertGetId([
            'name' => 'Other Child',
            'date_of_birth' => '2015-01-01',
            'class_name' => 'Grade 5',
            'parent_id' => $otherParent->id,
        ]);

        $updateId = DB::table('teacher_updates')->insertGetId([
            'student_id' => $otherStudentId,
            'teacher_id' => $teacher->id,
            'category' => 'Academic',
            'note' => 'Other student update.',
            'visible_to_parent' => true,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $update = DB::table('teacher_updates')
            ->where('id', $updateId)
            ->where('visible_to_parent', true)
            ->whereIn('student_id', function ($query) use ($parent) {
                $query->select('id')
                    ->from('students')
                    ->where('parent_id', $parent->id);
            })
            ->first();

        $this->assertNull($update);
    }
}
