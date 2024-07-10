<?php

use App\Http\Controllers\Professor\ProfessorAssignmentController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Professor\ProfessorModuleFolderController;
use App\Http\Controllers\Professor\ProfessorModuleContentController;
use App\Http\Controllers\Professor\ProfessorNewsController;
use App\Http\Controllers\Professor\ProfessorQuizController;
use App\Http\Controllers\Professor\ProfessorMeetingController;
use App\Http\Controllers\Student\StudentModuleContentController;
use App\Http\Controllers\Student\StudentNewsController;
use App\Http\Controllers\Student\StudentQuizController;
use App\Http\Controllers\Student\StudentMeetingController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/login', function () {
        return redirect()->route('login');
    })->name('filament.auth.login');
});

// Grouping routes for modules with professor role-based access
Route::middleware(['auth', 'professor', 'checkModuleOwnership'])->prefix('professor/modules/{module_id}')->name('modules.professor.')->group(function () {

    // Module Content Routes
    Route::resource('content', ProfessorModuleContentController::class);
    Route::resource('folder', ProfessorModuleFolderController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
    Route::get('content/{content_id}/view', [ProfessorModuleContentController::class, 'viewContent'])->name('content.view');

    // News Routes
    Route::resource('news', ProfessorNewsController::class);

    // Quiz Routes
    Route::resource('quizzes', ProfessorQuizController::class);

    // Meeting Routes
    Route::resource('meetings', ProfessorMeetingController::class)->only(['index', 'create', 'store']);

    //Assignment Routes
    Route::resource('assignments', ProfessorAssignmentController::class);
});

// Grouping routes for modules with student role-based access
Route::middleware(['auth', 'student', 'checkModuleOwnership'])->prefix('student/modules/{module_id}')->name('modules.student.')->group(function () {

    // Module Content Routes
    Route::resource('content', StudentModuleContentController::class)->only(['index', 'show']);
    Route::get('content/{content_id}/view', [StudentModuleContentController::class, 'viewContent'])->name('content.view');
    Route::post('content/toggle-favourite', [StudentModuleContentController::class, 'toggleFavouriteContent'])->name('content.toggle-favourite');
    Route::post('content/download', [StudentModuleContentController::class, 'downloadContent'])->name('content.download');
    Route::post('content/download/{content_id}', [StudentModuleContentController::class, 'downloadSingleContent'])->name('content.downloadSingle');

    // News Routes
    Route::resource('news', StudentNewsController::class)->only(['index', 'show']);

    // Quiz Routes
    Route::resource('quizzes', StudentQuizController::class)->only(['index', 'show']);
    Route::post('quizzes/{id}/attempt', [StudentQuizController::class, 'attempt'])->name('quizzes.attempt');

    // Meeting Routes
    Route::resource('meetings', StudentMeetingController::class)->only(['index', 'update']);
});


require __DIR__ . '/auth.php'; // Include the routes defined in the routes/auth.php file for authentication related routes.