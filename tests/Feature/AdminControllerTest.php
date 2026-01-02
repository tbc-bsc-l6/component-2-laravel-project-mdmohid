<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Module;
use App\Models\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminControllerTest extends TestCase
{
  use RefreshDatabase;

  protected $admin;

  protected function setUp(): void
  {
    parent::setUp();

    // Seed roles
    UserRole::insert([
      ['id' => 1, 'role' => 'admin'],
      ['id' => 2, 'role' => 'teacher'],
      ['id' => 3, 'role' => 'student'],
      ['id' => 4, 'role' => 'old_student'],
    ]);

    // Create an admin user
    $this->admin = User::factory()->create([
      'user_role_id' => 1,
      'email' => 'admin@example.com',
    ]);
  }

  /** @test */
  public function admin_can_access_dashboard()
  {
    $response = $this->actingAs($this->admin)->get(route('admin.dashboard'));

    $response->assertStatus(200);
    $response->assertViewIs('admin.dashboard');
  }

  /** @test */
  public function admin_can_create_module()
  {
    $response = $this->actingAs($this->admin)->post(route('admin.modules.store'), [
      'module' => 'Math 101',
      'description' => 'Basic Math Module',
      'active' => 1,
    ]);

    $response->assertRedirect();

    $this->assertDatabaseHas('modules', [
      'module' => 'Math 101',
      'description' => 'Basic Math Module',
      'active' => 1,
    ]);
  }

  /** @test */
  public function admin_can_toggle_module_status()
  {
    $module = Module::factory()->create(['active' => true]);

    $response = $this->actingAs($this->admin)->patch(route('admin.modules.toggle', $module->id));

    $response->assertRedirect();

    $this->assertDatabaseHas('modules', [
      'id' => $module->id,
      'active' => false,
    ]);
  }

  /** @test */
  public function admin_can_create_teacher()
  {
    $response = $this->actingAs($this->admin)->post(route('admin.teachers.store'), [
      'name' => 'John Doe',
      'email' => 'teacher1@example.com',
      'password' => 'password123',
      'user_role_id' => 2,
    ]);

    $response->assertRedirect();

    $this->assertDatabaseHas('users', [
      'email' => 'teacher1@example.com',
      'user_role_id' => 2,
    ]);
  }

  /** @test */
  public function admin_can_change_user_role()
  {
    $student = User::factory()->create([
      'user_role_id' => 3,
    ]);

    $response = $this->actingAs($this->admin)->patch(route('admin.users.update-role', $student->id), [
      'user_role_id' => 2,
    ]);

    $response->assertRedirect();

    $this->assertDatabaseHas('users', [
      'id' => $student->id,
      'user_role_id' => 2,
    ]);
  }

  /** @test */
  public function admin_can_delete_teacher()
  {
    $teacher = User::factory()->create([
      'user_role_id' => 2,
    ]);

    $response = $this->actingAs($this->admin)->delete(route('admin.teachers.destroy', $teacher->id));

    $response->assertRedirect();

    $this->assertDatabaseMissing('users', [
      'id' => $teacher->id,
    ]);
  }
}
