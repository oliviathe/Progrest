<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;

class ProfileController extends Controller
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

        $user = auth()->user(); 

        return view('profile.index', [
            'menu' => $menu, 
            'projects' => $user->projects()->latest()->get()
        ]); 
    }
}
