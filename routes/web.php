<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\navBarController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TimeslotController;
use App\Http\Controllers\Professor\ProfessorModuleFolderController;
use App\Http\Controllers\Professor\ProfessorModuleContentController;
use App\Http\Controllers\Professor\ProfessorNewsController;
use App\Http\Controllers\Professor\ProfessorQuizController;
use App\Http\Controllers\Student\StudentModuleContentController;
use App\Http\Controllers\Student\StudentNewsController;
use App\Http\Controllers\Student\StudentQuizController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
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
    Route::resource('folder', ProfessorModuleFolderController::class)->except(['index', 'show']);
    Route::get('content/{content_id}/view', [ProfessorModuleContentController::class, 'viewContent'])->name('content.view');

    // News Routes
    Route::resource('news', ProfessorNewsController::class);

    // Quiz routes
    Route::resource('quizzes', ProfessorQuizController::class);

    // // Quiz routes
    // Route::prefix('quizzes')->name('modules.quizzes.professor.')->group(function () {
    //     Route::get('/', [QuizController::class, 'indexForProfessor'])->name('index');
    //     Route::get('create', [QuizController::class, 'createForProfessor'])->name('create');
    //     Route::post('/', [QuizController::class, 'storeForProfessor'])->name('store');
    //     Route::get('{id}', [QuizController::class, 'showForProfessor'])->name('show');
    //     Route::get('{id}/edit', [QuizController::class, 'editForProfessor'])->name('edit');
    //     Route::put('{id}', [QuizController::class, 'updateForProfessor'])->name('update');
    //     Route::delete('{id}', [QuizController::class, 'destroyForProfessor'])->name('destroy');
    // });

    // Meetings routes
    Route::prefix('meetings')->name('modules.meetings.professor.')->group(function () {
        Route::get('meetings', [MeetingController::class, 'index'])->name('index');
        Route::get('meetings/create', [MeetingController::class, 'create'])->name('create');
        Route::post('meetings', [MeetingController::class, 'store'])->name('store');
    });
});

// Timeslot Routes
// Route::get('timeslots', [TimeslotController::class, 'index'])->name('timeslots.index');
// Route::get('timeslots/create', [TimeslotController::class, 'create'])->name('timeslots.create');
// Route::post('timeslots', [TimeslotController::class, 'store'])->name('timeslots.store');

// // Meeting Routes
// Route::get('meetings', [MeetingController::class, 'index'])->name('professor.meetings.index');
// Route::get('meetings/create', [MeetingController::class, 'create'])->name('professor.meetings.create');
// Route::post('meetings', [MeetingController::class, 'store'])->name('professor.meetings.store');
// Route::patch('meetings/{id}', [MeetingController::class, 'update'])->name('meetings.update');

// Grouping routes for modules with student role-based access
Route::middleware(['auth', 'student', 'checkModuleOwnership'])->prefix('student/modules/{module_id}')->name('modules.student.')->group(function () {
    //Route::get('dashboard', [ModuleController::class, 'dashboard'])->name('modules.dashboard.student');

    // Module Content Routes
    Route::resource('content', StudentModuleContentController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
    Route::get('content/{content_id}/view', [StudentModuleContentController::class, 'viewContent'])->name('content.view');
    Route::post('content/toggle-favourite', [StudentModuleContentController::class, 'toggleFavouriteContent'])->name('content.toggle-favourite');
    Route::post('content/download', [StudentModuleContentController::class, 'downloadContent'])->name('content.download');
    Route::post('content/download/{content_id}', [StudentModuleContentController::class, 'downloadSingleContent'])->name('content.downloadSingle');

    // News Routes
    Route::resource('news', StudentNewsController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);

    // Quiz Routes
    Route::resource('quizzes', StudentQuizController::class)->except(['create', 'store', 'edit', 'update', 'destroy']);
    Route::post('quizzes/{id}/attempt', [StudentQuizController::class, 'attempt'])->name('quizzes.attempt');

    // // Quiz routes
    // Route::prefix('quizzes')->name('modules.quizzes.student.')->group(function () {
    //     Route::get('/', [QuizController::class, 'indexForStudent'])->name('index');
    //     Route::get('{id}', [QuizController::class, 'showForStudent'])->name('show');
    //     Route::post('{id}/attempt', [QuizController::class, 'attempt'])->name('attempt');
    // });

    // Meetings routes
    Route::prefix('meetings')->name('modules.meetings.student.')->group(function () {
        Route::get('meetings', [MeetingController::class, 'indexForStudent'])->name('index');
        Route::patch('meetings/{meeting_id}', [MeetingController::class, 'update'])->name('update');
        // Route::patch('/modules/{module_id}/meetings/{meeting_id}/update', 'MeetingController@update')->name('modules.meetings.student.update');
    });

});

require __DIR__ . '/auth.php'; // Include the routes defined in the routes/auth.php file for authentication related routes.