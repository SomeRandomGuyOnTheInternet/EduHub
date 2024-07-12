<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class QuizSeeder extends Seeder
{
    public function run()
    {
        $moduleIds = [1, 2, 3];
        $titles = ['Quiz 1', 'Quiz 2', 'Quiz 3'];
        $quizDates = [
            Carbon::create(2024, 7, 25),
            Carbon::create(2024, 7, 26),
            Carbon::create(2024, 7, 27),
        ];

        foreach ($moduleIds as $index => $moduleId) {
            DB::table('quiz')->insert([
                'module_id' => $moduleId,
                'quiz_title' => $titles[$index],
                'quiz_description' => 'Description for ' . $titles[$index],
                'quiz_date' => $quizDates[$index],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}