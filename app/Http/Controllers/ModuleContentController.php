<?php

namespace App\Http\Controllers;

use App\Models\News;
use App\Models\Module;
use App\Models\Favourite;
use App\Models\ModuleFolder;
use Illuminate\Http\Request;
use App\Models\ModuleContent;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;


class ModuleContentController extends Controller
{
    public function indexForProfessor($module_id)
    {
        $module = Module::findOrFail($module_id);
        $folders = ModuleFolder::where('module_id', $module_id)->with('contents')->get();
        return view('professor.content.index', compact('module', 'folders'));
    }

    public function showForProfessor($module_id, $content_id)
    {
        $module = Module::findOrFail($module_id);
        $content = ModuleContent::findOrFail($content_id);
        return view('professor.content.show', compact('module', 'content'));
    }

    // Method to show form to create a new folder
    public function createFolder($module_id)
    {
        $module = Module::findOrFail($module_id);
        return view('professor.content.create_folder', compact('module'));
    }

    // Method to store a new folder
    public function storeFolder(Request $request, $module_id)
    {
        $request->validate([
            'folder_name' => 'required|string|max:255',
        ]);

        ModuleFolder::create([
            'module_id' => $module_id,
            'folder_name' => $request->folder_name,
        ]);

        return redirect()->route('modules.content.professor.index', ['module_id' => $module_id])
            ->with('success', 'Folder created successfully.');
    }

    // Method to show form to create new content
    public function createContent($module_id)
    {
        Log::info("Creating content for module: $module_id");
        $module = Module::findOrFail($module_id);
        $folders = ModuleFolder::where('module_id', $module_id)->get();
        return view('professor.content.create_content', compact('module', 'folders'));
    }

    public function storeContent(Request $request, $module_id)
    {
        // Validate the incoming request data
        $request->validate([
            'module_folder_id' => 'required|exists:module_folders,module_folder_id', 
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file_path' => 'nullable|file',
        ]);

        // Initialize the $filePath variable
        $filePath = null;

        // Check if the file is present
        if ($request->hasFile('file_path')) {
            // Get the original file name
            $originalFileName = $request->file('file_path')->getClientOriginalName();

            // Store the file with the original name in the 'contents' directory
            $filePath = $request->file('file_path')->storeAs('contents', $originalFileName);
        }

        // Create a new ModuleContent record in the database
        ModuleContent::create([
            'module_folder_id' => $request->module_folder_id, // Ensure this matches the column name in your database
            'title' => $request->title,
            'description' => $request->description,
            'file_path' => $filePath,
            'upload_date' => now(), // This assumes you have an 'upload_date' column in your module_contents table
        ]);

        // Redirect to the module content index page with a success message
        return redirect()->route('modules.content.professor.index', ['module_id' => $module_id])
            ->with('success', 'Content created successfully.');
    }

    public function editFolder($module_id, $folder_id)
    {
        $module = Module::findOrFail($module_id);
        $folder = ModuleFolder::findOrFail($folder_id);
        return view('professor.content.edit_folder', compact('module', 'folder'));
    }

    public function updateFolder(Request $request, $module_id, $folder_id)
    {
        $request->validate([
            'folder_name' => 'required|string|max:255',
        ]);

        $folder = ModuleFolder::findOrFail($folder_id);
        $folder->update([
            'folder_name' => $request->folder_name,
        ]);

        return redirect()->route('modules.content.professor.index', ['module_id' => $module_id])
            ->with('success', 'Folder updated successfully.');
    }

    public function destroyFolder($module_id, $folder_id)
    {
        $folder = ModuleFolder::findOrFail($folder_id);
        $folder->delete();

        return redirect()->route('modules.content.professor.index', ['module_id' => $module_id])
            ->with('success', 'Folder deleted successfully.');
    }

    public function editContent($module_id, $content_id)
    {
        $module = Module::findOrFail($module_id);
        $content = ModuleContent::findOrFail($content_id);
        $folders = ModuleFolder::where('module_id', $module_id)->get();
        return view('professor.content.edit_content', compact('module', 'content', 'folders'));
    }

    public function updateContent(Request $request, $module_id, $content_id)
    {
        $request->validate([
            'module_folder_id' => 'required|exists:module_folders,module_folder_id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'file_path' => 'nullable|file',
        ]);
    
        $content = ModuleContent::findOrFail($content_id);
    
        // Initialize the $data array with the updated values
        $data = [
            'module_folder_id' => $request->module_folder_id,
            'title' => $request->title,
            'description' => $request->description,
        ];
    
        // Check if a new file is uploaded
        if ($request->hasFile('file_path')) {
            // Delete the old file if it exists
            if ($content->file_path && Storage::exists($content->file_path)) {
                Storage::delete($content->file_path);
            }
    
            // Store the new file with its original name
            $originalFileName = $request->file('file_path')->getClientOriginalName();
            $data['file_path'] = $request->file('file_path')->storeAs('contents', time() . '_' . $originalFileName);
        }
    
        // Update the content record in the database
        $content->update($data);
    
        return redirect()->route('modules.content.professor.index', ['module_id' => $module_id])
            ->with('success', 'Content updated successfully.');
    }
    

    public function destroyContent($module_id, $content_id)
    {
        $content = ModuleContent::findOrFail($content_id);
    
        // Delete the file from storage if it exists
        if ($content->file_path && Storage::exists($content->file_path)) {
            Storage::delete($content->file_path);
        }
    
        // Delete the content record from the database
        $content->delete();
    
        return redirect()->route('modules.content.professor.index', ['module_id' => $module_id])
            ->with('success', 'Content deleted successfully.');
    }
    

    public function indexForStudent($module_id)
    {
        $module = Module::findOrFail($module_id);
        $folders = ModuleFolder::where('module_id', $module_id)->with('contents')->get();
        $favouriteContentIds = Favourite::where('user_id', Auth::id())->pluck('content_id')->toArray();
        return view('student.content.index', compact('module', 'folders', 'favouriteContentIds'));
    }


    public function toggleFavouriteContent(Request $request, $module_id)
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('modules.content.student.index', ['module_id' => $module_id])
                ->with('error', 'User not authenticated.');
        }

        foreach ($request->content_ids as $content_id) {
            $favourite = Favourite::where('user_id', $user->user_id)
                ->where('content_id', $content_id)
                ->first();

            if ($favourite) {
                $favourite->delete();
            } else {
                Favourite::create([
                    'user_id' => $user->user_id,
                    'content_id' => $content_id,
                    'module_id' => $module_id
                ]);
            }
        }

        return redirect()->route('modules.content.student.index', ['module_id' => $module_id])
            ->with('success', 'Content favourite status toggled successfully.');
    }


    public function downloadContent(Request $request)
    {
        $zip = new \ZipArchive;
        $fileName = 'content.zip';

        if ($zip->open(public_path($fileName), \ZipArchive::CREATE) === TRUE) {
            foreach ($request->content_ids as $content_id) {
                $content = ModuleContent::find($content_id);
                if ($content && $content->file_path) {
                    $fileContents = Storage::get($content->file_path);
                    $relativeNameInZipFile = basename($content->file_path);
                    $zip->addFromString($relativeNameInZipFile, $fileContents);
                }
            }
            $zip->close();
        }

        return response()->download(public_path($fileName))->deleteFileAfterSend(true);
    }

    public function downloadSingleContent($module_id, $content_id)
    {
        $content = ModuleContent::findOrFail($content_id);

        // Get the file path from the content
        $filePath = storage_path('app/' . $content->file_path);

        // Check if file exists
        if (!file_exists($filePath)) {
            return redirect()->route('modules.content.student.index', ['module_id' => $module_id])
                ->with('error', 'File not found.');
        }

        // Return the file as a download response
        return response()->download($filePath, basename($filePath));
    }

    public function viewContent($module_id, $content_id)
    {
        $content = ModuleContent::findOrFail($content_id);
        $path = storage_path('app/' . $content->file_path);

        if (!file_exists($path)) {
            abort(404);
        }

        return response()->file($path);
    }

    public function showForStudent($module_id, $content_id)
    {
        $module = Module::findOrFail($module_id);
        $content = ModuleContent::with('favourites')->findOrFail($content_id);
        return view('student.content.show', compact('module', 'content'));
    }



    // public function index($moduleFolderId)
    // {
    //     // Fetch all ModuleContent entries with the given module_folder_id and load the related module
    //     $moduleContents = ModuleContent::with('module')
    //                                    ->where('module_folder_id', $moduleFolderId)
    //                                    ->get();

    //     // Handle cases where there is no content available or the module is not defined
    //     if ($moduleContents->isEmpty()) {
    //         $moduleName = 'No Module Name';
    //     } else {
    //         // Fetch module name from the first content item's related module, if available
    //         $moduleName = optional($moduleContents->first()->module)->module_name ?? 'No Module Name';
    //     }

    //     if (Auth::user()->role === 'professor') {
    //         return view('content.create', compact('moduleFolderId'));
    //     }

    //     $userId = Auth::id();
    //     $userType = Auth::user()->user_type;

    //     if ($userType == 'professor') {
    //         // Fetch the module names and IDs for professors
    //         $modules = DB::table('modules')
    //             ->join('teaches', 'modules.module_id', '=', 'teaches.module_id')
    //             ->where('teaches.user_id', $userId)
    //             ->select('modules.module_name', 'modules.module_id') // Include module_id in the selection
    //             ->get();
    //     } elseif ($userType == 'student') {
    //         // Fetch the module names and IDs for students
    //         $modules = DB::table('modules')
    //             ->join('enrollments', 'modules.module_id', '=', 'enrollments.module_id')
    //             ->where('enrollments.user_id', $userId)
    //             ->select('modules.module_name', 'modules.module_id') // Include module_id in the selection
    //             ->get();
    //     } else {
    //         // If not professor or student, maybe redirect or handle differently
    //         $modules = collect(); // Return an empty collection or handle as needed
    //     }

    //     return view('content.content_dashboard', compact('moduleContents', 'modules','moduleName'));
    // }

    // public function store(Request $request, $moduleFolderId)
    // {
    //     $request->validate([
    //         'title' => 'required|string|max:100',
    //         'description' => 'required|string',
    //         'file' => 'required|file|max:10240', // Allows files up to 10MB
    //     ]);

    //     $filePath = $request->file('file')->store('module_contents');

    //     $content = new ModuleContent([
    //         'module_folder_id' => $moduleFolderId,
    //         'title' => $request->input('title'),
    //         'description' => $request->input('description'),
    //         'file_path' => $filePath,
    //         'upload_date' => now(),
    //         'created_at' => now(),
    //         'updated_at' => now()
    //     ]);

    //     $content->save();

    //     return back()->with('success', 'Content uploaded successfully!');
    // }
}