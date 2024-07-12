<?php

namespace Database\Seeders;

use App\Models\Enrollment;
use App\Models\Faculty;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            UniversitySeeder::class,
            ModuleSeeder::class,
            ModuleContentSeeder::class,
            EnrollmentSeeder::class,
            FavouriteSeeder::class,
            TeachesSeeder::class,
            AdminSeeder::class,
            AssignmentSeeder::class,
            QuizSeeder::class,
        ]);
    }
}
