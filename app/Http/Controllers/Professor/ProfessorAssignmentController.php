<?php

namespace App\Http\Controllers\Professor;

use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AssignmentSubmission;

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
            'file' => 'nullable|file|max:2048',
        ]);

        $filePath = null;
        $originalFileName = null;
        if ($request->hasFile('file')) {
            $file = $request->file('file');
            $originalFileName = $file->getClientOriginalName();
            $filePath = $file->storeAs('assignments', $originalFileName, 'public');
        }

        $assignment = new Assignment();
        $assignment->module_id = $module_id;
        $assignment->title = $request->title;
        $assignment->weightage = $request->weightage;
        $assignment->description = $request->description;
        $assignment->due_date = $request->due_date;
        $assignment->file_path = $filePath;

        $assignment->save();

        // Debugging statement to check assignment data
        logger()->info('Assignment Data:', $assignment->toArray());

        return redirect()->route('modules.professor.assignments.index', $module_id)
            ->with('success', 'Assignment created successfully.');
    }

    public function show($module_id, $assignment_id)
    {
        $assignment = Assignment::findOrFail($assignment_id);

        // Extract the file name from the file path
        $fileName = basename($assignment->file_path);

        return view('professor.assignment.show', compact('assignment', 'module_id', 'fileName'));
    }


    public function destroy($module_id, $assignment_id)
    {
        $assignment = Assignment::findOrFail($assignment_id);
        $assignment->delete();

        return redirect()->route('modules.professor.assignments.index', $module_id)
            ->with('success', 'Assignment deleted successfully.');
    }

    public function viewSubmissions($module_id, $assignment_id)
    {
        $assignment = Assignment::findOrFail($assignment_id);
        $submissions = $assignment->submissions()->with('user')->get();
        return view('professor.assignment.submissions', compact('assignment', 'submissions', 'module_id'));
    }

    public function gradeSubmission(Request $request, $module_id, $assignment_id, $submission_id)
    {
        $request->validate([
            'grade' => 'required|numeric|min:0|max:100',
            'feedback' => 'nullable|string',
        ]);

        $submission = AssignmentSubmission::findOrFail($submission_id);
        $submission->grade = $request->grade;
        $submission->feedback = $request->feedback;
        $submission->save();

        return redirect()->route('modules.professor.assignments.submissions', [$module_id, $assignment_id])
                         ->with('success', 'Grade and feedback submitted successfully.');
    }
}