<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class EnrollmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create();

        // Retrieve all students
        $studentIds = DB::table('users')->where('user_type', 'student')->pluck('user_id');
        // Fetch actual module IDs from the modules table
        $moduleIds = DB::table('modules')->pluck('module_id')->toArray();

        foreach ($studentIds as $studentId) {
            // Shuffle module IDs to get random modules for each student
            shuffle($moduleIds);
            // Select the first three module IDs for enrollment
            $selectedModules = array_slice($moduleIds, 0, 3);
            
            foreach ($selectedModules as $moduleId) {
                // Insert the enrollment record
                DB::table('enrollments')->insert([
                    'user_id' => $studentId,
                    'module_id' => $moduleId,
                    'enrollment_date' => $faker->date('Y-m-d', 'now'),
                ]);
            }
        }
    }
}
