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
        // Hardcoded assignments of module IDs to student user IDs
        // Replace these IDs with the actual student IDs from your screenshot
        $enrollments = [
            1 => [1, 2, 4, 8], // Assuming user_id 1 is a student
            4 => [2, 3, 9, 10], // Assuming user_id 2 is a student
            5 => [6, 7, 9, 8, 10],
            7 => [3, 5, 6, 7], // Assuming user_id 3 is a student
            11 => [6, 7, 9, 8, 10],
        ];

        // Retrieve only the student IDs from the database to confirm they are students
        $studentIds = DB::table('users')->where('user_type', 'student')->pluck('user_id')->toArray();

        foreach ($enrollments as $studentId => $modules) {
            if (in_array($studentId, $studentIds)) {
                foreach ($modules as $moduleId) {
                    // Check if the module ID exists to avoid foreign key constraint errors
                    if (DB::table('modules')->where('module_id', $moduleId)->exists()) {
                        DB::table('enrollments')->insert([
                            'user_id' => $studentId,
                            'module_id' => $moduleId,
                            'enrollment_date' => now(),
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);
                    }
                }
            }
        }
    }
}
