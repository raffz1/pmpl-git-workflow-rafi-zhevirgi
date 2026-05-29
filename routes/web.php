<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExplorePathController;

Route::get('/', function () {
    return view('LandingPage'); 
});

Route::get('/login', function () {
    return view('Login');
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

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
});
