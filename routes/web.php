<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;

Route::get('/', [DashboardController::class, 'index']);

// Route::get('/', function(){
//     return view('landing'); 
// });

Route::get('/sign-in', function() {
    return view('signin'); 
})->name('signin.view'); 