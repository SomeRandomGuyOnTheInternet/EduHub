<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class ModuleContentSeeder extends Seeder
{
    // /**
    //  * Run the database seeds.
    //  */
    public function run(): void
    {
        $folders = DB::table('module_folders')->get(['module_folder_id', 'module_id', 'folder_name']);

        foreach ($folders as $folder) {
            $folderName = strtolower($folder->folder_name);
            $contentTemplates = $this->getContentTemplates($folderName);

            foreach ($contentTemplates as $index => $content) {
                // Ensuring unique document number by using folder ID and an index
                $docNumber = $folder->module_folder_id * 100 + $index + 1;
                $title = "{$content['title']} {$docNumber}";
                $description = $content['description'];

                DB::table('module_contents')->insert([
                    'module_folder_id' => $folder->module_folder_id,
                    'title' => $title,
                    'description' => $description,
                    'file_path' => '',  // File path is set to empty
                    'upload_date' => now(),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }

    /**
     * Get content templates based on the folder type
     *
     * @param string $folderType
     * @return array
     */
    private function getContentTemplates($folderType)
    {
        switch ($folderType) {
            case 'lecture':
                return [
                    ['title' => 'Lecture Notes on', 'description' => 'Detailed lecture notes covering all key concepts discussed during the session.'],
                    ['title' => 'Lecture Slides on', 'description' => 'Slides from the lecture, including diagrams and summary points.'],
                    ['title' => 'Lecture Video on', 'description' => 'Recorded video of the full lecture for revision and distance learning.']
                ];

            case 'tutorial':
                return [
                    ['title' => 'Tutorial Worksheet on', 'description' => 'Worksheet with exercises and problems to solve during tutorials.'],
                    ['title' => 'Tutorial Solutions for', 'description' => 'Detailed solutions to the problems presented in the tutorial worksheet.'],
                    ['title' => 'Tutorial Discussion on', 'description' => 'Summary of discussions and key points from the tutorial session.']
                ];

            case 'practical':
                return [
                    ['title' => 'Practical Lab Instructions for', 'description' => 'Step-by-step instructions to carry out the lab exercises.'],
                    ['title' => 'Practical Lab Report Template for', 'description' => 'Template for submitting reports on practical lab exercises.'],
                    ['title' => 'Practical Skills Video on', 'description' => 'Video demonstrations of essential skills required for the lab.']
                ];

            default:
                return [];  // Return an empty array for unknown folder types
        }
    }

}