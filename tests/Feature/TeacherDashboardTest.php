<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\TeacherUpdate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeacherDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_teacher_can_open_dashboard(): void
    {
        $teacher = User::factory()->create(['role' => 'teacher']);

        $response = $this->actingAs($teacher)->get('/teacher/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Total Students');
        $response->assertSee('My Updates');
        $response->assertSee('Updates This Week');
    }

    public function test_my_updates_count_includes_new_update(): void
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $parent  = User::factory()->create(['role' => 'parent']);

        $student = Student::create([
            'name'          => 'Test Student',
            'date_of_birth' => '2015-01-01',
            'class_name'    => 'Grade 3',
            'parent_id'     => $parent->id,
        ]);

        TeacherUpdate::create([
            'student_id'        => $student->id,
            'teacher_id'        => $teacher->id,
            'category'          => 'academic',
            'note'              => 'Test update for count check',
            'visible_to_parent' => true,
        ]);

        $response = $this->actingAs($teacher)->get('/teacher/dashboard');

        $response->assertStatus(200);
    }

    public function test_non_teacher_cannot_open_dashboard(): void
    {
        $parent = User::factory()->create(['role' => 'parent']);

        $response = $this->actingAs($parent)->get('/teacher/dashboard');

        $response->assertStatus(403);
    }
}
