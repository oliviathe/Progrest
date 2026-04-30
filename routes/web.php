<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CollabController;

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProjectController;
use Illuminate\Support\Facades\Route;

Route::get('/', function() {
    return view('landing.index'); 
})->name('landing.index'); 

Route::get('/register', function() {
    return view('auth.register'); 
})->name('register.view'); 

Route::get('/login', [AuthController::class, 'index'])->name('login.index'); 
Route::post('/login', [AuthController::class, 'login'])->name('login');

Route::get('/dashboard', [DashboardController::class, 'index']); 
Route::get('/projects', [ProjectController::class, 'index']); 
Route::get('/collab', [CollabController::class, 'index']); 
Route::get('/profile', [ProfileController::class, 'index']); 