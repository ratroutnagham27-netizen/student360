<?php

namespace Tests\Feature;

use App\Models\ParentConsent;
use App\Models\Student;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParentDashboardProfileLinkTest extends TestCase
{
    use RefreshDatabase;

    public function test_parent_dashboard_links_to_the_student_profile(): void
    {
        $parent = User::factory()->create(['role' => 'parent']);

        ParentConsent::create([
            'user_id'   => $parent->id,
            'agreed_at' => now(),
        ]);

        Student::create([
            'name'          => 'Test Child',
            'date_of_birth' => '2015-01-01',
            'class_name'    => 'Grade 3',
            'parent_id'     => $parent->id,
        ]);

        $this->actingAs($parent)
            ->get(route('parent.dashboard'))
            ->assertOk()
            ->assertSee('View full profile')
            ->assertSee(route('student.profile'), false);
    }

    public function test_parent_dashboard_without_a_linked_student_has_no_profile_link(): void
    {
        $parent = User::factory()->create(['role' => 'parent']);

        ParentConsent::create([
            'user_id'   => $parent->id,
            'agreed_at' => now(),
        ]);

        $this->actingAs($parent)
            ->get(route('parent.dashboard'))
            ->assertOk()
            ->assertDontSee('View full profile');
    }
}