<?php

/*namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
       

        User::create([
            'name' => 'Another User',
            'email' => 'a@user.com',
            'email_verified_at' => now(),
            'password' => bcrypt('1234'),
            'user_role_id' => 1,
        ]);
    }
}
*/



namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\UserRole;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // Create Admin user safely
        $adminRole = UserRole::where('role', 'admin')->first();

        if ($adminRole) {
            User::firstOrCreate(
                ['email' => 'admin@example.com'],
                [
                    'name' => 'Admin User',
                    'email_verified_at' => now(),
                    'password' => Hash::make('password'),
                    'user_role_id' => $adminRole->id,
                ]
            );
        } else {
            $this->command->warn('Admin role not found - skipping admin user creation');
        }

        // existing test user set to likely student (safe with firstOrCreate)
        $studentRole = UserRole::where('role', 'student')->first();

        User::firstOrCreate(
            ['email' => 'a@user.com'],
            [
                'name' => 'Another User',
                'email_verified_at' => now(),
                'password' => Hash::make('1234'),
                'user_role_id' => $studentRole ? $studentRole->id : null,
            ]
        );
    }
}