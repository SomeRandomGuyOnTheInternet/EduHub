<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Student\StudentNewsController;
use App\Http\Controllers\Student\StudentQuizController;
use App\Http\Controllers\Student\StudentMeetingController;
use App\Http\Controllers\Professor\ProfessorNewsController;
use App\Http\Controllers\Professor\ProfessorQuizController;
use App\Http\Controllers\Student\StudentDashboardController;
use App\Http\Controllers\Professor\ProfessorDashboardController;
use App\Http\Controllers\Professor\ProfessorMeetingController;
use App\Http\Controllers\Student\StudentModuleContentController;
use App\Http\Controllers\Student\StudentAssignmentController;
use App\Http\Controllers\Professor\ProfessorAssignmentController;
use App\Http\Controllers\Professor\ProfessorModuleHomeController;
use App\Http\Controllers\Professor\ProfessorModuleFolderController;
use App\Http\Controllers\Professor\ProfessorModuleContentController;
use App\Http\Controllers\Student\StudentModuleHomeController;
use Illuminate\Support\Facades\Auth;

Route::get('/', function () {
    $user = Auth::user(); // Define the $user variable

    if ($user) {
        if ($user->user_type === 'admin') {
            return redirect()->intended('/admin');
        } elseif ($user->user_type === 'professor') {
            return redirect()->intended(route('professor.dashboard'));
        } elseif ($user->user_type === 'student') {
            return redirect()->intended(route('student.dashboard'));
        }
    } else {
        return redirect()->route('login');
    }
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    //Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//only for student to go to dashboard
Route::middleware(['auth', 'student'])->group(function () {
    Route::get('/student/dashboard', [StudentDashboardController::class, 'index'])->name('student.dashboard');
});

//only for professor to go to dashbaord
Route::middleware(['auth', 'professor'])->group(function () {
    Route::get('/professor/dashboard', [ProfessorDashboardController::class, 'index'])->name('professor.dashboard');
});

//only for admin routing
Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/login', function () {
        return redirect()->route('login');
    })->name('filament.auth.login');
});

// Grouping routes for modules with professor role-based access
Route::middleware(['auth', 'professor', 'checkModuleOwnership'])->prefix('professor/modules/{module_id}')->name('modules.professor.')->group(function () {
    Route::resource('home', ProfessorModuleHomeController::class);

    // Module Content Routes
    Route::resource('content', ProfessorModuleContentController::class);
    Route::resource('folder', ProfessorModuleFolderController::class)->only(['create', 'store', 'edit', 'update', 'destroy']);
    Route::get('content/{content_id}/view', [ProfessorModuleContentController::class, 'viewContent'])->name('content.view');

    // News Routes
    Route::resource('news', ProfessorNewsController::class);

    // Quiz Routes
    Route::resource('quizzes', ProfessorQuizController::class);

    // Meeting Routes
    Route::resource('meetings', ProfessorMeetingController::class);

    //Assignment Routes
    Route::resource('assignments', ProfessorAssignmentController::class);

});

// Grouping routes for modules with student role-based access
Route::middleware(['auth', 'student', 'checkModuleOwnership'])->prefix('student/modules/{module_id}')->name('modules.student.')->group(function () {
    Route::resource('home', StudentModuleHomeController::class);

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
    Route::resource('meetings', StudentMeetingController::class);
    Route::patch('meetings/{meeting}/update-booking', [StudentMeetingController::class, 'updateBooking'])->name('meetings.updateBooking');

    Route::resource('assignment', StudentAssignmentController::class);
});


require __DIR__ . '/auth.php'; // Include the routes defined in the routes/auth.php file for authentication related routes.