<?php

namespace Database\Seeders;

use Carbon\Carbon; 
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $this->call([
            UserSeeder::class, 
            ProjectSeeder::class, 
            TaskSeeder::class, 
            TaskCollaborationSeeder::class, 
            TaskSubmissionSeeder::class
        ]); 
    }
}
