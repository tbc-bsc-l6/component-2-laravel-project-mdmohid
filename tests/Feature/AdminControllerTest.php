<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use App\Models\Module;
use App\Models\UserRole;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;

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

    // Create admin
    $this->admin = User::factory()->create([
      'user_role_id' => 1,
      'email' => 'admin@example.com',
      'password' => Hash::make('password123'),
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
      'active' => true,
    ]);

    $response->assertRedirect();

    $this->assertDatabaseHas('modules', [
      'module' => 'Math 101',
      'active' => true,
    ]);
  }

  /** @test */
  // public function admin_can_toggle_module_status()
  // {
  //   $module = Module::factory()->create(['active' => true]);

  //   $response = $this->actingAs($this->admin)
  //     ->patch(route('admin.modules.toggle', $module->id));

  //   $response->assertRedirect();

  //   $this->assertDatabaseHas('modules', [
  //     'id' => $module->id,
  //     'active' => false,
  //   ]);
  // }


  /** @test */
  public function admin_can_toggle_module_status()
  {
    $module = Module::factory()->create(['active' => true]);

    $response = $this->actingAs($this->admin)
      ->patch(route('admin.modules.toggle', $module->slug));

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
      'password_confirmation' => 'password123', // ✅ must match controller
    ]);

    $response->assertRedirect();

    $teacher = User::where('email', 'teacher1@example.com')->first();

    $this->assertNotNull($teacher, 'Teacher was not created');
    $this->assertEquals(2, $teacher->user_role_id, 'Teacher role not assigned correctly');
  }

  /** @test */
  public function admin_can_change_user_role()
  {
    $student = User::factory()->create(['user_role_id' => 3]);

    // Controller expects 'role' => 'teacher' (string)
    $response = $this->actingAs($this->admin)
      ->post(route('admin.users.change-role', $student->id), [
        'role' => 'teacher',
      ]);

    $response->assertRedirect();

    $student->refresh();

    $this->assertEquals(2, $student->user_role_id, 'User role was not updated');
  }

  /** @test */
  public function admin_can_delete_teacher()
  {
    $teacher = User::factory()->create(['user_role_id' => 2]);

    $response = $this->actingAs($this->admin)
      ->delete(route('admin.teachers.destroy', $teacher->id));

    $response->assertRedirect();

    $this->assertDatabaseMissing('users', [
      'id' => $teacher->id,
    ]);
  }
}
