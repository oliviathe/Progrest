<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CollabController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProjectMemberController;
use App\Http\Controllers\ProjectTaskController;
use App\Http\Controllers\TaskController;
use Illuminate\Support\Facades\Route;

Route::middleware(['guest'])->group(function(){
    Route::get('/', function () {
        return view('landing.index');
    })->name('landing');

    Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])
        ->name('google.login');

    Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    Route::post('/register', [AuthController::class, 'register']);

    Route::get('/login', [AuthController::class, 'index'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);

    Route::get('/forgot', function () {
        return view('auth.forgot');
    })->name('forgot');

    Route::post('/forgot', [AuthController::class, 'sendOtp'])->name('forgot.send');

    Route::get('/otp', function () {
        return view('auth.otp');
    })->name('otp');

    Route::post('/otp', [AuthController::class, 'verifyOtp'])->name('otp.verify'); 

    Route::get('/reset-password', function () {
        return view('auth.reset');
    })->name('reset.password');


    Route::post('/reset-password', [AuthController::class, 'resetPassword'])
        ->name('reset.password.submit'); 
}); 

Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth');

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    Route::get('/projects', [ProjectController::class, 'index'])
        ->name('projects.index');

    Route::post('/projects', [ProjectController::class, 'store'])
        ->name('projects.store');

    Route::get('/profile', [ProfileController::class, 'index'])
        ->name('profile');

    Route::post('/profile', [ProfileController::class, 'update'])
        ->name('profile.update');
    
    Route::get('/projects/{id}', [ProjectTaskController::class, 'index'])->name('projects.tasks');

    Route::get(
        '/projects/{project}/members/search',
        [ProjectMemberController::class, 'search']
    );
    
    Route::get('/collab', [CollabController::class, 'index']);
});