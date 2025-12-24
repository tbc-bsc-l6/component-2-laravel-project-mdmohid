<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $modules = [
            'Web Application Technology',
            'Object Orientated Programming',
            'Developing Mobile Applications',
            'Advanced Web Engineering',
        ];
        foreach ($modules as $module) {
            \App\Models\Module::firstOrCreate([
                'module' => $module,
            ]);
        }
    }
}
