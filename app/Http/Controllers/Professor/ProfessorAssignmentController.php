<?php

namespace App\Http\Controllers\Professor;

use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProfessorAssignmentController extends Controller
{
    public function index($module_id)
    {
        $assignments = Assignment::where('module_id', $module_id)->get();
        return view('professor.assignment.index', compact('assignments', 'module_id'));
    }

    public function create($module_id)
    {
        return view('professor.assignment.create', compact('module_id'));
    }

    public function store(Request $request, $module_id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'weightage' => 'required|numeric',
            'description' => 'required|string',
            'due_date' => 'required|date',
        ]);

        Assignment::create([
            'module_id' => $module_id,
            'title' => $request->title,
            'weightage' => $request->weightage,
            'description' => $request->description,
            'due_date' => $request->due_date,
        ]);

        return redirect()->route('modules.professor.assignments.index', $module_id)
                         ->with('success', 'Assignment created successfully.');
    }

    public function show($module_id, $assignment_id)
    {
        $assignment = Assignment::findOrFail($assignment_id);
        return view('professor.assignment.show', compact('assignment', 'module_id'));
    }

    public function destroy($module_id, $assignment_id)
    {
        $assignment = Assignment::findOrFail($assignment_id);
        $assignment->delete();

        return redirect()->route('modules.professor.assignments.index', $module_id)
                         ->with('success', 'Assignment deleted successfully.');
    }
}
