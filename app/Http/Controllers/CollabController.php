<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use App\Models\TaskCollaboration;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollabController extends Controller{

    public function index(Request $request){
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
        $search = $request->input('search');

        $searchFilter = function ($query) use ($search) {
            if ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('project', function ($project) use ($search) {
                        $project->where('title', 'like', "%{$search}%");
                    });
                });
            }
        };

        $activeCollabTasks = Task::with([
            'project.leader',
            'project.users',
            'users',
            'collaborations' => function ($query) {
                $query->where('user_id', auth()->id());
            },
        ])
        ->whereHas('collaborations', function ($query) {
            $query->where('user_id', auth()->id());
        })
        // ->whereNotIn('status', ['completed', 'cancelled'])
        ->tap($searchFilter)
        ->latest()
        ->take(3)
        ->get();

        $activeCollabTasksCount = Task::whereHas('collaborations', function ($query) {
            $query->where('user_id', auth()->id());
        })
        // ->whereNotIn('status', ['completed', 'cancelled'])
        ->count();

        $allCollabTasks = Task::with([
            'project.leader',
            'project.users',
            'users',
        ])
        ->where('go_collab_enabled', true)
        ->whereIn('status', ['pending', 'in_progress'])
        ->whereDoesntHave('users', function ($query) use ($user) {
            $query->where('users.id', $user->id);
        })
        ->whereDoesntHave('collaborators', function ($query) use ($user) {
            $query->where('users.id', $user->id);
        })
        ->whereDoesntHave('project.users', function ($query) use ($user) {
            $query->where('users.id', $user->id);
        })
        ->whereHas('project', function ($query) use ($user) {
            $query->where('leader_id', '!=', $user->id);
        })
        ->tap($searchFilter)
        ->latest()
        ->paginate(9);

        return view('collab.index', compact('menu', 'user', 'allCollabTasks', 'activeCollabTasks', 'activeCollabTasksCount'));
    }
    
    public function active(Request $request){
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

        $user = auth()->user();

        $search = $request->search;
        $sort = $request->sort ?? 'deadline';
        $direction = $request->direction ?? 'asc';

        $activeCollabTasks = Task::with([
                'project.leader',
                'project',
                'collaborators',
            ])
            ->whereHas('collaborators', function ($query) use ($user) {
                $query->where('users.id', $user->id)
                    ->where('task_collaborations.status', 'in_progress');
            });

        if ($search) {
            $activeCollabTasks->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%")
                    ->orWhereHas('project', function ($project) use ($search) {
                        $project->where('title', 'like', "%{$search}%");
                    });
            });
        }

        switch ($sort) {
            case 'alphabetical':
                $activeCollabTasks->orderBy('title', $direction);
                break;

            case 'deadline':
                $activeCollabTasks->orderBy('deadline', $direction);
                break;

            default:
                $activeCollabTasks->latest();
                break;
        }

        $activeCollabTasks = $activeCollabTasks
            ->paginate(9)
            ->withQueryString();

        return view('collab.active.index', compact('menu', 'activeCollabTasks'));
    }
}