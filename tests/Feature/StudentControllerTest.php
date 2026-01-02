<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Module;
use App\Models\Enrollment;
use App\Models\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;

class StudentControllerTest extends TestCase
{
  use RefreshDatabase;

  protected $student;

  protected function setUp(): void
  {
    parent::setUp();

    // Seed user roles
    UserRole::insert([
      ['id' => 1, 'role' => 'admin'],
      ['id' => 2, 'role' => 'teacher'],
      ['id' => 3, 'role' => 'student'],
      ['id' => 4, 'role' => 'old_student'],
    ]);

    // Create a student
    $this->student = User::factory()->create([
      'user_role_id' => 3, // Student role
    ]);
  }

  /** @test */
  public function student_can_view_dashboard()
  {
    $response = $this->actingAs($this->student)
      ->get(route('student.dashboard'));

    $response->assertStatus(200);
    $response->assertViewIs('student.dashboard');
  }

  /** @test */
  public function student_can_enrol_in_module()
  {
    $module = Module::factory()->create(['active' => true]);

    $response = $this->actingAs($this->student)
      ->post(route('student.enrol', $module->id));

    $response->assertRedirect();
    $response->assertSessionHas('success', 'Enrolled successfully!');

    $this->assertDatabaseHas('enrollments', [
      'user_id' => $this->student->id,
      'module_id' => $module->id,
    ]);
  }

  /** @test */
  public function student_cannot_enrol_if_module_is_inactive()
  {
    $module = Module::factory()->create(['active' => false]);

    $response = $this->actingAs($this->student)
      ->post(route('student.enrol', $module->id));

    $response->assertRedirect();

    $this->assertEquals(
      ['This module is not available.'],
      $response->getSession()->get('errors')->all()
    );
  }

  /** @test */
  public function student_cannot_enrol_in_more_than_4_active_modules()
  {
    $modules = Module::factory()->count(5)->create(['active' => true]);

    // Enrol student in 4 modules first
    foreach ($modules->take(4) as $module) {
      Enrollment::create([
        'user_id' => $this->student->id,
        'module_id' => $module->id,
        'enrolled_at' => now(),
      ]);
    }

    // Try enrolling in the 5th module
    $response = $this->actingAs($this->student)
      ->post(route('student.enrol', $modules[4]->id));

    $response->assertRedirect();

    $this->assertEquals(
      ['You can only enroll in a maximum of 4 current modules.'],
      $response->getSession()->get('errors')->all()
    );
  }

  /** @test */
  public function student_cannot_enrol_in_same_module_twice()
  {
    $module = Module::factory()->create(['active' => true]);

    // First enrolment
    Enrollment::create([
      'user_id' => $this->student->id,
      'module_id' => $module->id,
      'enrolled_at' => now(),
    ]);

    // Attempt second enrolment
    $response = $this->actingAs($this->student)
      ->post(route('student.enrol', $module->id));

    $response->assertRedirect();

    $this->assertEquals(
      ['You are already enrolled in this module.'],
      $response->getSession()->get('errors')->all()
    );
  }
}
