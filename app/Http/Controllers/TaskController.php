<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TaskController extends Controller{
    public function index($project_id, $task_id){
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
        
        return view('projects.tasks.view-task', compact('menu', 'project_id', 'task_id')); 
    }
}
