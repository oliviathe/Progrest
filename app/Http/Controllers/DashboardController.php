<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;

class DashboardController extends Controller
{
    public function index(){
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

        $projects = Project::with('users', 'tasks')->get(); 

        $priorityTasks = Task::where('is_completed', false)
            ->orderBy('deadline')
            ->take(2)
            ->get();

        $allTasks = Task::with('users', 'project')
            ->latest()
            ->get();

        $user = Auth()->user(); 

        return view('dashboard.index', [
            'menu' => $menu, 
            'projects' => $user->projects()->latest()->get(), 
            'priorityTasks', 
            'allTasks', 
            'user'
        ]); 
    }
}
