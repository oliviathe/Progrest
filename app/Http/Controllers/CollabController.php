<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CollabController extends Controller
{
    public function index() {
        $menu = [
            [
                'navigations' => [
                    ['name' => 'Dashboard', 'path' => '/dashboard'], 
                    ['name' => 'Projects', 'path' => '/projects'], 
                    ['name' => 'Collab', 'path' => '/collab'], 
                    ['name' => 'Profiles', 'path' => '/profile']
                ]
            ]
        ]; 

        return view('collab.index', compact('menu')); 
    }
}
