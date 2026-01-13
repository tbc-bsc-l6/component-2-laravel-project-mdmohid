<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Module;
use App\Models\Enrollment;
use App\Models\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TeacherControllerTest extends TestCase
{
  use RefreshDatabase;
  //private $teacher;

  protected function setUp(): void
  {
    parent::setUp();

    UserRole::insert([
      ['id' => 1, 'role' => 'admin'],
      ['id' => 2, 'role' => 'teacher'],
      ['id' => 3, 'role' => 'student'],
      ['id' => 4, 'role' => 'old_student'],
    ]);
  }

  /** @test */
  public function teacher_can_view_dashboard()
  {
    $teacher = User::factory()->teacher()->create();

    $module = Module::factory()->create([
      'teacher_id' => $teacher->id,
      'teacher_name' => $teacher->name,
    ]);

    $student = User::factory()->student()->create();

    Enrollment::create([
      'user_id' => $student->id,
      'module_id' => $module->id,
      'enrolled_at' => now(),
    ]);

    $response = $this->actingAs($teacher)->get(route('teacher.dashboard'));

    $response->assertStatus(200);
    $response->assertViewIs('teacher.dashboard');
  }

  /** @test */
  public function teacher_can_pass_student()
  {
    $teacher = User::factory()->teacher()->create();

    $module = Module::factory()->create([
      'teacher_id' => $teacher->id,
    ]);

    $student = User::factory()->student()->create();

    $enrollment = Enrollment::create([
      'user_id' => $student->id,
      'module_id' => $module->id,
      'enrolled_at' => now(),
    ]);

    $response = $this->actingAs($teacher)->post(
      route('teacher.grade', $enrollment->id),
      ['pass' => true]
    );

    $response->assertRedirect();

    $this->assertDatabaseHas('enrollments', [
      'id' => $enrollment->id,
      'pass' => true,
    ]);
  }

  /** @test */
  public function teacher_can_fail_student()
  {
    $teacher = User::factory()->teacher()->create();

    $module = Module::factory()->create([
      'teacher_id' => $teacher->id,
    ]);

    $student = User::factory()->student()->create();

    $enrollment = Enrollment::create([
      'user_id' => $student->id,
      'module_id' => $module->id,
      'enrolled_at' => now(),
    ]);

    $response = $this->actingAs($teacher)->post(
      route('teacher.grade', $enrollment->id),
      ['pass' => false]
    );

    $this->assertDatabaseHas('enrollments', [
      'id' => $enrollment->id,
      'pass' => false,
    ]);
  }
}
