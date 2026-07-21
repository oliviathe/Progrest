<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;

class CollabController extends Controller{

    public function index(){
        $menu = [
            [
                'navigations' => [
                    ['name'=>'Dashboard','path'=>'/dashboard'],
                    ['name'=>'Projects','path'=>'/projects'],
                    ['name'=>'Collab','path'=>'/collab'],
                    ['name'=>'Profiles','path'=>'/profile'],
                ]
            ]
        ];

        $user = Auth::user();

        $tasks = Task::with([
            'project.leader',
            'project.users',
            'users',
        ])
        ->where('go_collab_enabled', true)
        ->whereIn('status', ['pending', 'in_progress'])
        ->whereDoesntHave('users', function ($query) use ($user) {
            $query->where('users.id', $user->id);
        })
        ->latest()
        ->paginate(9);

        return view('collab.index', compact('menu', 'user', 'tasks'));
    }

    
}