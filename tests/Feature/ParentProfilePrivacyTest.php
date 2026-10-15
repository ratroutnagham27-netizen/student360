<?php

namespace Tests\Feature;

use App\Models\Student;
use App\Models\TeacherUpdate;
use App\Models\User;
use App\Models\ParentConsent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParentProfilePrivacyTest extends TestCase
{
    use RefreshDatabase;

    public function test_parent_does_not_see_confidential_note(): void
    {
        $parent  = User::factory()->create(['role' => 'parent']);
        $teacher = User::factory()->create(['role' => 'teacher']);

        ParentConsent::create([
            'user_id'   => $parent->id,
            'agreed_at' => now(),
        ]);
        $student = Student::create([
            'name'          => 'Test Child',
            'date_of_birth' => '2015-01-01',
            'class_name'    => 'Grade 3',
            'parent_id'     => $parent->id,
        ]);

        TeacherUpdate::create([
            'student_id'        => $student->id,
            'teacher_id'        => $teacher->id,
            'category'          => 'academic',
            'note'              => 'Great work this week',
            'visible_to_parent' => true,
        ]);

        TeacherUpdate::create([
            'student_id'        => $student->id,
            'teacher_id'        => $teacher->id,
            'category'          => 'behavioral',
            'note'              => 'Confidential: needs closer attention',
            'visible_to_parent' => false,
        ]);

        $response = $this->actingAs($parent)->get('/student-profile');

        $response->assertStatus(200);
        $response->assertSee('Great work this week');
        $response->assertDontSee('Confidential: needs closer attention');
    }

    public function test_teacher_sees_all_notes(): void
    {
        $parent  = User::factory()->create(['role' => 'parent']);
        $teacher = User::factory()->create(['role' => 'teacher']);

        $student = Student::create([
            'name'          => 'Test Child',
            'date_of_birth' => '2015-01-01',
            'class_name'    => 'Grade 3',
            'parent_id'     => $parent->id,
        ]);

        TeacherUpdate::create([
            'student_id'        => $student->id,
            'teacher_id'        => $teacher->id,
            'category'          => 'behavioral',
            'note'              => 'Confidential: needs closer attention',
            'visible_to_parent' => false,
        ]);

        $response = $this->actingAs($teacher)->get('/student-profile');

        $response->assertStatus(200);
        $response->assertSee('Confidential: needs closer attention');
    }

    public function test_parent_with_no_child_gets_403(): void
    {
        $parent = User::factory()->create(['role' => 'parent']);

        ParentConsent::create([
            'user_id'   => $parent->id,
            'agreed_at' => now(),
        ]);

        $response = $this->actingAs($parent)->get('/student-profile');

        $response->assertStatus(403);
    }
}