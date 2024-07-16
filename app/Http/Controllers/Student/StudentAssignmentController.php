<?php

namespace App\Http\Controllers\Student;

use App\Models\Assignment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\AssignmentSubmission;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;

class StudentAssignmentController extends Controller
{
    public function index($module_id)
    {
        $assignments = Assignment::where('module_id', $module_id)->get();
        $submissions = AssignmentSubmission::where('user_id', Auth::id())->get();

        return view('student.assignment.index', compact('assignments', 'submissions', 'module_id'));
    }
    public function show($module_id, $assignment_id)
    {
        Log::info('Accessing show method in StudentAssignmentController');
        Log::info('Module ID: ' . $module_id);
        Log::info('Assignment ID: ' . $assignment_id);
    
        $assignment = Assignment::findOrFail($assignment_id);
    
        if ($assignment->module_id != $module_id) {
            Log::error('Module ID mismatch. Redirecting to dashboard.');
            return redirect()->route('student.dashboard')->with('error', 'Invalid module assignment access.');
        }
    
        return view('student.assignment.show', compact('assignment', 'module_id'));
    }
    
    public function submit(Request $request, $module_id, $assignment_id)
    {
        // Log the request data for debugging
        Log::info('Form Data:', $request->all());

        $request->validate([
            'description' => 'required|string',
            'files.*' => 'required|file|max:10240',
        ]);

        $filePaths = [];
        if ($request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $fileName = $file->getClientOriginalName();
                $filePath = $file->storeAs('submissions', $fileName, 'public');
                $filePaths[] = $filePath;
            }
        }

        AssignmentSubmission::create([
            'assignment_id' => $assignment_id,
            'user_id' => Auth::id(),
            'submission_description' => $request->description,
            'submission_files' => json_encode($filePaths), // Ensure the file paths are stored correctly
            'submission_date' => now(),
        ]);

        return redirect()->route('modules.student.assignments.show', [$module_id, $assignment_id])
            ->with('success', 'Assignment submitted successfully.');
    }
    
    public function download($module_id, $assignment_id)
    {
        $assignment = Assignment::findOrFail($assignment_id);

        if (!Storage::disk('public')->exists($assignment->file_path)) {
            return redirect()->back()->with('error', 'File does not exist.');
        }

        return Storage::disk('public')->download($assignment->file_path);
    }

}