<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class ProjectTaskController extends Controller
{
    public function index($id) {

        $userId = auth()->id();
        $project = Project::findOrFail($id); 

        $hasAccess =
            $project->leader_id === $userId ||
            $project->users()->where('user_id', $userId)->exists();

        abort_unless($hasAccess, 403);
        
        $allTasks = $project->tasks()
            ->orderBy('is_completed')
            ->orderByRaw("
                CASE priority
                    WHEN 'high' THEN 1
                    WHEN 'medium' THEN 2
                    WHEN 'low' THEN 3
                END
            ")
            ->orderBy('deadline')
            ->get();

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

        $priorityTasks = $project->tasks()->where('is_completed', false)->where('status', '!=' ,'cancelled')
            ->whereDate('deadline', '<=', today())
            ->orderByRaw("
                FIELD(priority,
                    'urgent',
                    'high',
                    'medium',
                    'low'
                )
            ")
            ->orderBy('deadline')
            ->get(); 

        // Masih statik 
        $avatarPath = asset('images/profile.jpg');   
        $teamMembers = [
            $avatarPath,
            $avatarPath,
            $avatarPath,
            $avatarPath,
            $avatarPath
        ];
        $displayLimit = 3;
        $extraMembers = count($teamMembers) - $displayLimit;

        return view('projects.tasks.index', compact('project', 'menu', 'priorityTasks', 'allTasks', 
            'avatarPath', 'teamMembers', 'displayLimit', 'extraMembers'));
    }
}
