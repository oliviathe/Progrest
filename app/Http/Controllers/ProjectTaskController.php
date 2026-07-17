<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\Request;

class ProjectTaskController extends Controller
{
    public function index($id, Request $request) {

        $userId = auth()->id();
        $project = Project::findOrFail($id); 

        $hasAccess =
            $project->leader_id === $userId ||
            $project->users()->where('user_id', $userId)->exists();

        abort_unless($hasAccess, 403);

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

        $completedTasks = $project->tasks->where('is_completed', true)->count(); 
        $totalTasks = $project->tasks->count(); 

        $progress = $totalTasks > 0
            ? ($completedTasks / $totalTasks) * 100
            : 0;

        $sort = $request->get('sort', 'priority'); 
        $search = $request->get('search'); 
        $direction = $request->get('direction', 'desc'); 

        $query = $project->tasks()
            ->orderBy('is_completed'); 

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                ->orWhere('description', 'like', "%{$search}%"); 
            });
        }


        $priorityOrder = $direction === 'asc'
        ? "
            CASE priority
                WHEN 'low' THEN 1
                WHEN 'medium' THEN 2
                WHEN 'high' THEN 3
            END
        "
        : "
            CASE priority
                WHEN 'high' THEN 1
                WHEN 'medium' THEN 2
                WHEN 'low' THEN 3
            END
        ";

        switch ($sort) {
            case 'alphabetical':
                $query->orderBy('title', $direction);
                break;

            case 'deadline':
                $query->orderBy('deadline', $direction);
                break;

            default: // priority
                $query->orderByRaw($priorityOrder)
                    ->orderBy('deadline');
                break;
        }

        $allTasks = $query->get();

        return view('projects.tasks.index', compact('project', 'menu', 'priorityTasks', 'allTasks', 
            'avatarPath', 'teamMembers', 'displayLimit', 'extraMembers', 'completedTasks', 
            'totalTasks', 'progress'));
    }
}
