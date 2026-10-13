<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\TeacherUpdate;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeacherUpdateFormPageTest extends TestCase
{
    use RefreshDatabase;

   private function createStudent(?User $homeroomTeacher = null): Student
{
    $parent = User::factory()->create(['role' => 'parent']);

    return Student::create([
        'name'                 => 'Test Child',
        'date_of_birth'        => '2015-01-01',
        'class_name'           => 'Grade 3',
        'parent_id'            => $parent->id,
        'homeroom_teacher_id'  => $homeroomTeacher?->id,
    ]);
}

    public function test_teacher_can_open_create_page_and_sees_students(): void
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $student = $this->createStudent();

        $response = $this->actingAs($teacher)->get('/teacher/updates/create');

        $response->assertOk();
        $response->assertSee($student->name);
        $response->assertSee('Add Teacher Update');
    }

    public function test_parent_gets_403_on_create_page(): void
    {
        $parent = User::factory()->create(['role' => 'parent']);

        $response = $this->actingAs($parent)->get('/teacher/updates/create');

        $response->assertStatus(403);
    }

    public function test_admin_gets_403_on_create_page(): void
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get('/teacher/updates/create');

        $response->assertStatus(403);
    }

    public function test_guest_is_redirected_to_login(): void
    {
        $response = $this->get('/teacher/updates/create');

        $response->assertRedirect(route('login'));
    }

    public function test_valid_submit_with_checkbox_checked_saves_visible_true(): void
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
         $student = $this->createStudent($teacher);

        $response = $this->actingAs($teacher)->post('/teacher-updates', [
            'student_id'        => $student->id,
            'category'          => 'academic',
            'note'              => 'Test visible update for parent',
            'visible_to_parent' => '1',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('teacher_updates', [
            'student_id'        => $student->id,
            'teacher_id'        => $teacher->id,
            'visible_to_parent' => 1,
        ]);
    }

    public function test_valid_submit_with_checkbox_unchecked_saves_visible_false(): void
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $student = $this->createStudent($teacher); 

        $response = $this->actingAs($teacher)->post('/teacher-updates', [
            'student_id'        => $student->id,
            'category'          => 'behavioral',
            'note'              => 'Test hidden update',
            'visible_to_parent' => '0',
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('teacher_updates', [
            'student_id'        => $student->id,
            'teacher_id'        => $teacher->id,
            'visible_to_parent' => 0,
        ]);
    }
}
