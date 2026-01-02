<?php

// namespace Database\Factories;

// use Illuminate\Database\Eloquent\Factories\Factory;

// /**
//  * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Enrollment>
//  */
// class EnrollmentFactory extends Factory
// {
//     /**
//      * Define the model's default state.
//      *
//      * @return array<string, mixed>
//      */
//     public function definition(): array
//     {
//         return [
//             //
//         ];
//     }
// }




namespace Database\Factories;

use App\Models\User;
use App\Models\Module;
use Illuminate\Database\Eloquent\Factories\Factory;

class EnrollmentFactory extends Factory
{
  public function definition(): array
  {
    return [
      'user_id' => User::factory()->student(), // student role
      'module_id' => Module::factory(),
      'enrolled_at' => now(),
      'completed_at' => null,
      'pass' => null,
    ];
  }

  public function completed(): static
  {
    return $this->state([
      'completed_at' => now()->subDays(rand(10, 60)),
      'pass' => fake()->boolean(80), // 80% pass rate
    ]);
  }
}
