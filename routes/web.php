<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('landing');
});

Route::get('/sign-in', function() {
    return view('signin'); 
})->name('signin.view'); 