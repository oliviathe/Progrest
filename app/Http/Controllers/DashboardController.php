<?php

namespace App\Http\Controllers;

class DashboardController extends Controller
{
    public function index(){
        $menu = [
            [
                'title' => 'Main', 
                'items' => [
                    ['name' => 'Dashboard', 'path' => '/'], 
                    ['name' => 'Users', 'path' => '/']
                ]
            ]
        ]; 

        return view('pages.dashboard', compact('menu')); 
    }
}
