<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class AssignmentSeeder extends Seeder
{
    public function run()
    {
        $moduleIds = [1, 2, 3];
        $titles = ['Assignment 1', 'Assignment 2', 'Assignment 3'];
        $weightages = ['10%', '20%', '30%'];
        $dueDates = [
            Carbon::create(2024, 7, 20),
            Carbon::create(2024, 7, 22),
            Carbon::create(2024, 7, 29),
        ];

        foreach ($moduleIds as $index => $moduleId) {
            DB::table('assignments')->insert([
                'module_id' => $moduleId,
                'title' => $titles[$index],
                'weightage' => $weightages[$index],
                'description' => 'Description for ' . $titles[$index],
                'due_date' => $dueDates[$index],
                'file_path' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
