<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExplorePathController;

Route::get('/', function () {
    return view('LandingPage'); 
});

// Authentication Routes
Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', [AuthController::class, 'registerProcess']);

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', [AuthController::class, 'loginProcess']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Explore Path (public access)
Route::get('/explore', [ExplorePathController::class, 'index'])->name('explore.path');
Route::get('/path/detail/frontend', [ExplorePathController::class, 'frontendDetail'])->name('path.detail.frontend');
Route::post('/path/detail/frontend/complete', [ExplorePathController::class, 'completeStep'])->name('path.frontend.complete');
Route::post('/path/detail/frontend/reset', [ExplorePathController::class, 'resetDetailProgress'])->name('path.frontend.reset');

Route::get('/path/detail/backend', [ExplorePathController::class, 'backendDetail'])->name('path.detail.backend');
Route::post('/path/detail/backend/complete', [ExplorePathController::class, 'completeBackendStep'])->name('path.backend.complete');
Route::post('/path/detail/backend/reset', [ExplorePathController::class, 'resetBackendDetailProgress'])->name('path.backend.reset');

Route::get('/path/detail/fullstack', [ExplorePathController::class, 'fullstackDetail'])->name('path.detail.fullstack');
Route::post('/path/detail/fullstack/complete', [ExplorePathController::class, 'completeFullstackStep'])->name('path.fullstack.complete');
Route::post('/path/detail/fullstack/reset', [ExplorePathController::class, 'resetFullstackDetailProgress'])->name('path.fullstack.reset');

Route::get('/explore/enroll/{id}', [ExplorePathController::class, 'enroll'])->name('explore.enroll')->middleware('auth');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/reset', [DashboardController::class, 'resetProgress'])->name('dashboard.reset');
});
