<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\User;
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
        $admin = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $this->actingAs($admin)
            ->get(route('student.profile'))
            ->assertOk()
            ->assertSee('Teacher Notes & Achievements')
            ->assertSee('Jana participates actively')
            ->assertSee('Teacher Ms. Layla');
    }

    public function test_teacher_can_view_confidential_profile_notes(): void
    {
        $teacher = User::factory()->create([
            'role' => UserRole::TEACHER,
        ]);

        $this->actingAs($teacher)
            ->get(route('student.profile'))
            ->assertOk()
            ->assertSee('Teacher Notes & Achievements')
            ->assertSee('Jana participates actively')
            ->assertSee('Teacher Ms. Layla');
    }

    public function test_parent_only_sees_authorized_profile_information(): void
    {
        $parent = User::factory()->create([
            'role' => UserRole::PARENT,
        ]);

        $this->actingAs($parent)
            ->get(route('student.profile'))
            ->assertOk()
            ->assertSee('Academic Performance')
          ->assertSee('Behavioral & Participation', false)
            ->assertSee('Achievements')
            ->assertSee('Math Star')
            ->assertDontSee('Teacher Notes & Achievements')
            ->assertDontSee('Jana participates actively')
            ->assertDontSee('Teacher Ms. Layla');
    }
}