<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index']);

Route::get('/landing', function(){
    return view('landing'); 
}); 

// Route::get('/', function(){
//     return view('landing'); 
// });

Route::get('/sign-in', function() {
    return view('signin'); 
})->name('signin.view'); 

Route::get('/register', function() {
    return view('register'); 
})->name('register.view'); 