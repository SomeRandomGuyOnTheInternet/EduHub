<?php

namespace App\Http\Controllers\Professor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ProfessorModuleHomeController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        return view('professor.home.dashboard');
    }
}