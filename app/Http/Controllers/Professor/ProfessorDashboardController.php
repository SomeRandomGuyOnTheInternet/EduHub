<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;

class ProfessorDashboardController extends Controller
{
    public function index()
    {
        return view('professor.dashboard.index');
    }
}