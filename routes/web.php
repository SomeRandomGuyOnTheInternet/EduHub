<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\QuizController;
use App\Http\Controllers\ModuleContentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\AuthenticatedSessionController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\navBarController;
use App\Http\Controllers\TimeslotController;
use App\Http\Controllers\MeetingController;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/left-nav-bar', [NavBarController::class, 'showNavBar'])->name('left-nav-bar');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    //Route::get('/news/{moduleId}', [NewsController::class, 'show'])->name('news.show'); //Route to show news
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/admin/login', function () {
        return redirect()->route('login');
    })->name('filament.auth.login');
});



// Grouping routes for modules with professor role-based access
Route::middleware(['auth', 'professor'])->prefix('professor/modules/{module_id}')->group(function () {
    //Route::get('dashboard', [ModuleController::class, 'dashboard'])->name('modules.dashboard.professor');

    // Content routes
    Route::prefix('content')->name('modules.content.professor.')->group(function () {
        Route::get('/', [ModuleContentController::class, 'indexForProfessor'])->name('index');
        Route::get('{content_id}', [ModuleContentController::class, 'showForProfessor'])->name('show');
        Route::get('create-folder', [ModuleContentController::class, 'createFolder'])->name('create-folder');
        Route::post('store-folder', [ModuleContentController::class, 'storeFolder'])->name('store-folder');
        Route::get('create-content', [ModuleContentController::class, 'createContent'])->name('create-content');
        Route::post('store-content', [ModuleContentController::class, 'storeContent'])->name('store-content');
        Route::get('edit-folder/{folder_id}', [ModuleContentController::class, 'editFolder'])->name('edit-folder');
        Route::put('update-folder/{folder_id}', [ModuleContentController::class, 'updateFolder'])->name('update-folder');
        Route::delete('delete-folder/{folder_id}', [ModuleContentController::class, 'destroyFolder'])->name('delete-folder');
        Route::get('edit-content/{content_id}', [ModuleContentController::class, 'editContent'])->name('edit-content');
        Route::put('update-content/{content_id}', [ModuleContentController::class, 'updateContent'])->name('update-content');
        Route::delete('delete-content/{content_id}', [ModuleContentController::class, 'destroyContent'])->name('delete-content');
    });

    // Quiz routes
    Route::prefix('quizzes')->name('modules.quizzes.professor.')->group(function () {
        Route::get('/', [QuizController::class, 'indexForProfessor'])->name('index');
        Route::get('create', [QuizController::class, 'createForProfessor'])->name('create');
        Route::post('/', [QuizController::class, 'storeForProfessor'])->name('store');
        Route::get('{id}', [QuizController::class, 'showForProfessor'])->name('show');
        Route::get('{id}/edit', [QuizController::class, 'editForProfessor'])->name('edit');
        Route::put('{id}', [QuizController::class, 'updateForProfessor'])->name('update');
        Route::delete('{id}', [QuizController::class, 'destroyForProfessor'])->name('destroy');
    });

    // News routes
    Route::prefix('news')->name('modules.news.professor.')->group(function () {
        Route::get('/', [NewsController::class, 'indexForProfessor'])->name('index');
        Route::get('create', [NewsController::class, 'createForProfessor'])->name('create');
        Route::post('/', [NewsController::class, 'storeForProfessor'])->name('store');
        Route::get('{news_id}', [NewsController::class, 'showForProfessor'])->name('show');
        Route::get('{news_id}/edit', [NewsController::class, 'editForProfessor'])->name('edit');
        Route::put('{news_id}', [NewsController::class, 'updateForProfessor'])->name('update');
        Route::delete('{news_id}', [NewsController::class, 'destroyForProfessor'])->name('destroy');
    });
});

// Timeslot Routes
Route::get('timeslots', [TimeslotController::class, 'index'])->name('timeslots.index');
Route::get('timeslots/create', [TimeslotController::class, 'create'])->name('timeslots.create');
Route::post('timeslots', [TimeslotController::class, 'store'])->name('timeslots.store');

// Meeting Routes
Route::get('meetings', [MeetingController::class, 'index'])->name('meetings.index');
Route::get('meetings/create', [MeetingController::class, 'create'])->name('meetings.create');
Route::post('meetings', [MeetingController::class, 'store'])->name('meetings.store');
Route::patch('meetings/{id}', [MeetingController::class, 'update'])->name('meetings.update');

// Grouping routes for modules with student role-based access
Route::middleware(['auth', 'student'])->prefix('student/modules/{module_id}')->group(function () {
    //Route::get('dashboard', [ModuleController::class, 'dashboard'])->name('modules.dashboard.student');

    // Content routes
    Route::prefix('content')->name('modules.content.student.')->group(function () {
        Route::get('/', [ModuleContentController::class, 'indexForStudent'])->name('index');
        Route::get('{content_id}', [ModuleContentController::class, 'showForStudent'])->name('show');
        Route::post('toggle-favourite', [ModuleContentController::class, 'toggleFavouriteContent'])->name('toggle-favourite');
        Route::post('download', [ModuleContentController::class, 'downloadContent'])->name('download');
    });

    // Quiz routes
    Route::prefix('quizzes')->name('modules.quizzes.student.')->group(function () {
        Route::get('/', [QuizController::class, 'indexForStudent'])->name('index');
        Route::get('{id}', [QuizController::class, 'showForStudent'])->name('show');
        Route::post('{id}/attempt', [QuizController::class, 'attempt'])->name('attempt');
    });

    // News routes
    Route::prefix('news')->name('modules.news.student.')->group(function () {
        Route::get('/', [NewsController::class, 'indexForStudent'])->name('index');
        Route::get('{news_id}', [NewsController::class, 'showForStudent'])->name('show');
    });
});


// Route::get('/modules/{moduleFolderId}/content', [ModuleContentController::class, 'index'])->name('modules.content');

// Route::get('/modules', [navBarController::class, 'nav_bar'])->name('layouts.left-nav-bar');
// // routes/web.php
// Route::get('/modules/{module_id}/{page}', [navBarController::class, 'showPage'])->name('module.page');

// // this is from the nav bar 
// Route::get('/home/{module_id}', [navBarController::class, 'showHome'])->name('module.home');
// Route::get('/content/{module_id}', [navBarController::class, 'showContent'])->name('module.content');
// Route::get('/assignments/{module_id}', [navBarController::class, 'showAssignments'])->name('module.assignments');
// Route::get('/quizzes/{module_id}', [navBarController::class, 'showQuizzes'])->name('module.quizzes');
// Route::get('/news/{module_id}', [navBarController::class, 'showNews'])->name('module.news');
// Route::get('/meetings/{module_id}', [navBarController::class, 'showMeetings'])->name('module.meetings');

// Route::middleware(['auth', 'professor'])->group(function () {
//     Route::get('quizzes/create', [QuizController::class, 'create'])->name('quizzes.create'); // Route to create a quiz
//     Route::post('quizzes', [QuizController::class, 'store'])->name('quizzes.store'); // Route to store a new quiz
//     Route::get('/news/create-news/{moduleId}', [NewsController::class, 'create'])->name('news.create');
//     Route::post('/news/store-news', [NewsController::class, 'store'])->name('news.store'); //Route to store new News
//     Route::get('/news/{newsId}/edit', [NewsController::class, 'edit'])->name('news.edit'); // Route to show the form for editing a news item
//     Route::put('/news/{newsId}', [NewsController::class, 'update'])->name('news.update'); // Route to update a news item
//     Route::delete('/news/{newsId}', [NewsController::class, 'delete'])->name('news.delete'); // Route to delete a news item
//     Route::get('/modules/{moduleFolderId}/content', [ModuleContentController::class, 'index'])->name('modules.content');
//     Route::post('/modules/{moduleFolderId}/content/upload', [ModuleContentController::class, 'store'])->name('modules.content.store')->middleware('auth', 'professor');
// });

// Route::middleware(['auth', 'student'])->group(function () {
//     Route::post('quizzes/{quiz}/attempt', [QuizController::class, 'attempt'])->name('quizzes.attempt'); // Route to submit a quiz attempt
//     Route::get('quizzes/{quiz}', [QuizController::class, 'show'])->name('quizzes.show'); // Route to show a specific quiz
//     Route::get('user/quizzes', [QuizController::class, 'userQuizzes'])->name('user.quizzes'); // Route to display user's quizzes
//     Route::get('/modules/{moduleFolderId}/content', [ModuleContentController::class, 'index'])->name('modules.content');
// });
require __DIR__ . '/auth.php'; // Include the routes defined in the routes/auth.php file for authentication related routes.