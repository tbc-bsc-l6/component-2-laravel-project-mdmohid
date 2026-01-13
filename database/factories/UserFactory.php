<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserFactory extends Factory
{
  protected static ?string $password;

  public function definition(): array
  {
    return [
      'name' => fake()->name(),
      'email' => fake()->unique()->safeEmail(),
      'email_verified_at' => now(),
      'password' => static::$password ??= Hash::make('password'),
      'remember_token' => Str::random(10),
      'user_role_id' => 3, // default to student
    ];
  }

  public function unverified(): static
  {
    return $this->state(fn(array $attributes) => [
      'email_verified_at' => null,
    ]);
  }

  // Role states with fixed IDs (matching DB)
  public function admin(): static
  {
    return $this->state(['user_role_id' => 1]);
  }

  public function teacher(): static
  {
    return $this->state(['user_role_id' => 2]);
  }

  public function student(): static
  {
    return $this->state(['user_role_id' => 3]);
  }

  public function oldStudent(): static
  {
    return $this->state(['user_role_id' => 4]);
  }
}
