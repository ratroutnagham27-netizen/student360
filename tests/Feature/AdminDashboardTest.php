<?php

namespace Tests\Feature;

use App\Enums\UserRole;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminDashboardTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_dashboard(): void
    {
        $admin = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertViewIs('dashboards.admin');
    }

    public function test_dashboard_counts_reflect_database_records(): void
    {
        $admin = User::factory()->create([
            'role' => UserRole::ADMIN,
        ]);

        User::factory()->create([
            'role' => UserRole::TEACHER,
        ]);

        $parent = User::factory()->create([
            'role' => UserRole::PARENT,
        ]);

        $this->actingAs($admin)
            ->get(route('admin.dashboard'))
            ->assertOk()
            ->assertViewHas('totalStudents', 0)
            ->assertViewHas('totalTeachers', 1)
            ->assertViewHas('totalParents', 1);

        Student::create([
            'name' => 'Sara Demo',
            'date_of_birth' => '2018-04-10',
            'class_name' => '3A',
            'parent_id' => $parent->id,
        ]);

        User::factory()->create([
            'role' => UserRole::TEACHER,
        ]);

        User::factory()->create([
            'role' => UserRole::PARENT,
        ]);

        $this->get(route('admin.dashboard'))
            ->assertOk()
            ->assertViewHas('totalStudents', 1)
            ->assertViewHas('totalTeachers', 2)
            ->assertViewHas('totalParents', 2);
    }
}