<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Student;
use App\Models\TeacherUpdate;
use App\Models\User;
use App\Models\ParentConsent;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class StudentProfilePermissionsTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_cannot_access_student_profile(): void
    {
        $this->get(route('student.profile'))
            ->assertRedirect(route('login'));
    }

    public function test_admin_can_view_confidential_profile_notes(): void
    {
        $admin   = User::factory()->create(['role' => UserRole::ADMIN]);
        $teacher = User::factory()->create(['role' => UserRole::TEACHER]);
        $parent  = User::factory()->create(['role' => UserRole::PARENT]);

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

        $this->actingAs($admin)
            ->get(route('student.profile'))
            ->assertOk()
            ->assertSee('Teacher Updates Log')
            ->assertSee('Confidential: needs closer attention');
    }

    public function test_teacher_can_view_confidential_profile_notes(): void
    {
        $teacher = User::factory()->create(['role' => UserRole::TEACHER]);
        $parent  = User::factory()->create(['role' => UserRole::PARENT]);

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

        $this->actingAs($teacher)
            ->get(route('student.profile'))
            ->assertOk()
            ->assertSee('Teacher Updates Log')
            ->assertSee('Confidential: needs closer attention');
    }

    public function test_parent_only_sees_authorized_profile_information(): void
    {
        $teacher = User::factory()->create(['role' => UserRole::TEACHER]);
        $parent  = User::factory()->create(['role' => UserRole::PARENT]);

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
            'note'              => 'Great progress in mathematics',
            'visible_to_parent' => true,
        ]);

        TeacherUpdate::create([
            'student_id'        => $student->id,
            'teacher_id'        => $teacher->id,
            'category'          => 'behavioral',
            'note'              => 'Confidential: needs closer attention',
            'visible_to_parent' => false,
        ]);

        $this->actingAs($parent)
            ->get(route('student.profile'))
            ->assertOk()
            ->assertSee('Academic Performance')
            ->assertSee('Behavioral & Participation', false)
            ->assertSee('Great progress in mathematics')
            ->assertDontSee('Confidential: needs closer attention');
    }
}