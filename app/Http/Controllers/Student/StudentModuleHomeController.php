<?php

namespace App\Http\Controllers\Student;

use App\Models\Quiz;
use App\Models\Module;
use App\Models\Assignment;
use App\Models\Enrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class StudentModuleHomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        // Fetch module IDs based on user's enrollments
        $moduleIds = Enrollment::where('user_id', $user->user_id)->pluck('module_id');

        // Fetch assignments and quizzes based on module IDs
        $assignments = Assignment::whereIn('module_id', $moduleIds)
            ->select('assignment_id as id', 'title', 'due_date as start', 'module_id')
            ->get()
            ->each(function($item) {
                $item->type = 'assignment';
            });

        $quizzes = Quiz::whereIn('module_id', $moduleIds)
            ->select('quiz_id as id', 'quiz_title as title', 'quiz_date as start', 'module_id')
            ->get()
            ->each(function($item) {
                $item->type = 'quiz';
            });

        // Merge assignments and quizzes into events
        $events = $assignments->concat($quizzes);

        // Fetch module names and associate with events
        $moduleNames = Module::whereIn('module_id', $moduleIds)
            ->pluck('module_name', 'module_id');

        // Append module name to each event
        $events = $events->map(function ($event) use ($moduleNames) {
            $moduleId = $event->module_id;
            $moduleName = $moduleNames[$moduleId] ?? 'Unknown Module';

            // Append module name to the event object
            $event->module_name = $moduleName;

            return $event;
        });


        // Pass events to the view
        return view('student.home.dashboard', compact('events'));
    }
}
