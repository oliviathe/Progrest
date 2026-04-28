<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    $menu = [
        [
            'title' => 'Main',
            'items' => [
                ['name' => 'Dashboard', 'path' => '/'],
                ['name' => 'Users', 'path' => '/users'],
            ]
        ]
    ];

    return view('pages.dashboard', compact('menu'));
});

Route::get('/sign-in', function() {
    return view('signin'); 
})->name('signin.view'); 