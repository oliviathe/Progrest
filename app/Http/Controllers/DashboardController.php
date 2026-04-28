<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index(){
        $menu = [
            [
                'navigations' => [
                    ['name' => 'Dashboard', 'path' => '/dashboard'], 
                    ['name' => 'Projects', 'path' => '/projects'], 
                    ['name' => 'Collab', 'path' => '/collab'], 
                    ['name' => 'Profiles', 'path' => '/profiles']
                ]
            ]
        ]; 

        return view('pages.dashboard', compact('menu')); 
    }
}
