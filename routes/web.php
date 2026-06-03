<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ExplorePathController;
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    if (auth()->check()) {
        return redirect()->route('dashboard');
    }
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

// Explore Path (public access to list page only)
Route::get('/explore', [ExplorePathController::class, 'index'])->name('explore.path');

// Protected Routes
Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/dashboard/reset', [DashboardController::class, 'resetProgress'])->name('dashboard.reset');
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');

    // Detail paths are now protected:
    Route::get('/path/detail/frontend', [ExplorePathController::class, 'frontendDetail'])->name('path.detail.frontend');
    Route::post('/path/detail/frontend/complete', [ExplorePathController::class, 'completeStep'])->name('path.frontend.complete');
    Route::post('/path/detail/frontend/reset', [ExplorePathController::class, 'resetDetailProgress'])->name('path.frontend.reset');
    
    Route::get('/path/detail/backend', [ExplorePathController::class, 'backendDetail'])->name('path.detail.backend');
    Route::post('/path/detail/backend/complete', [ExplorePathController::class, 'completeBackendStep'])->name('path.backend.complete');
    Route::post('/path/detail/backend/reset', [ExplorePathController::class, 'resetBackendDetailProgress'])->name('path.backend.reset');
    
    Route::get('/path/detail/fullstack', [ExplorePathController::class, 'fullstackDetail'])->name('path.detail.fullstack');
    Route::post('/path/detail/fullstack/complete', [ExplorePathController::class, 'completeFullstackStep'])->name('path.fullstack.complete');
    Route::post('/path/detail/fullstack/reset', [ExplorePathController::class, 'resetFullstackDetailProgress'])->name('path.fullstack.reset');
    
    Route::get('/path/detail/project-manager', [ExplorePathController::class, 'pmDetail'])->name('path.detail.pm');
    Route::post('/path/detail/project-manager/complete', [ExplorePathController::class, 'completePmStep'])->name('path.pm.complete');
    Route::post('/path/detail/project-manager/reset', [ExplorePathController::class, 'resetPmDetailProgress'])->name('path.pm.reset');
    
    Route::get('/path/detail/uiux', [ExplorePathController::class, 'uiuxDetail'])->name('path.detail.uiux');
    Route::post('/path/detail/uiux/complete', [ExplorePathController::class, 'completeUiuxStep'])->name('path.uiux.complete');
    Route::post('/path/detail/uiux/reset', [ExplorePathController::class, 'resetUiuxDetailProgress'])->name('path.uiux.reset');

    Route::get('/explore/enroll/{id}', [ExplorePathController::class, 'enroll'])->name('explore.enroll');

    // Admin updates routes
    Route::post('/admin/path/{id}/update', [ExplorePathController::class, 'updatePath'])->name('admin.path.update');
    Route::post('/admin/module/{id}/update', [ExplorePathController::class, 'updateModule'])->name('admin.module.update');
    Route::post('/admin/quiz/{id}/update', [ExplorePathController::class, 'updateQuiz'])->name('admin.quiz.update');

    // Admin creations routes
    Route::post('/admin/path/store', [ExplorePathController::class, 'storePath'])->name('admin.path.store');
    Route::post('/admin/path/{path_id}/module/store', [ExplorePathController::class, 'storeModule'])->name('admin.module.store');

    // Admin deletions routes
    Route::post('/admin/path/{id}/delete', [ExplorePathController::class, 'deletePath'])->name('admin.path.delete');
    Route::post('/admin/module/{id}/delete', [ExplorePathController::class, 'deleteModule'])->name('admin.module.delete');

    // Generic detail paths and actions
    Route::get('/path/detail/{slug}', [ExplorePathController::class, 'detailBySlug'])->name('path.detail.dynamic');
    Route::post('/path/detail/{slug}/complete', [ExplorePathController::class, 'completeStepDynamic'])->name('path.detail.complete.dynamic');
    Route::post('/path/detail/{slug}/reset', [ExplorePathController::class, 'resetStepDynamic'])->name('path.detail.reset.dynamic');
    Route::post('/path/module/{id}/toggle-mark', [ExplorePathController::class, 'toggleModuleMark'])->name('path.module.toggle-mark');

    // Real-time updates polling
    Route::get('/api/path/{slug}/check-updates', [ExplorePathController::class, 'checkUpdates'])->name('api.path.check-updates');
    Route::get('/api/check-global-updates', [ExplorePathController::class, 'checkGlobalUpdates'])->name('api.check-global-updates');
});
