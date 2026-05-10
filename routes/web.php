<?php
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('LandingPage'); 
});

Route::get('/login', function () {
    return view('Login');
});

Route::get('/register', function () {
    return view('Register');
});

Route::post('/login-proses', [AuthController::class, 'login_proses']);

Route::get('/dashboard', function () {
    return view('Dashboard');
})->middleware('auth');