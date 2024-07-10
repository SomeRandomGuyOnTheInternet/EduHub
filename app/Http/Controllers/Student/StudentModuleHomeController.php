<?php

namespace App\Http\Controllers\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Assignment;
use App\Models\Quiz;

class StudentModuleHomeController extends Controller
{
    public function index()
    {
        
        $assignments = Assignment::select('assignment_id', 'title as title', 'due_date as start', 'due_date as end', 'module_id')
            ->get();
        
        $quizzes = Quiz::select('quiz_id', 'quiz_title as title', 'quiz_date as start', 'quiz_date as end', 'module_id')
            ->get();

        $events = $assignments->merge($quizzes);
        

        return view('dashboard', compact('events'));
    }
}
