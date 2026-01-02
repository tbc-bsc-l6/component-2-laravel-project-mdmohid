<?php

// namespace Database\Factories;

// use Illuminate\Database\Eloquent\Factories\Factory;

// /**
//  * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Module>
//  */
// class ModuleFactory extends Factory
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

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ModuleFactory extends Factory
{
  public function definition(): array
  {
    $name = fake()->unique()->words(3, true); // e.g. "Advanced Web Development"

    return [
      'module' => ucwords($name),
      'slug' => Str::slug($name),
      'active' => true,
      'teacher_id' => null,
      'teacher_name' => null,
    ];
  }
}
