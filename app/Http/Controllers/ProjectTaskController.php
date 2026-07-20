<?php

namespace App\Http\Controllers;

use App\Helpers\TaskImageHelper;
use App\Models\Project;
use App\Models\Task;
use App\Notifications\ActivityNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectTaskController extends Controller
{
    public function index($id, Request $request) {

        $userId = auth()->id();
        $project = Project::with([
            'leader',
            'users'
        ])->findOrFail($id);

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
        $teamMembers = $project->users
            ->map(function ($user) {
                return $user->avatar ?: asset('images/profile.jpg');
            })
            ->toArray();
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
            ->orderByRaw("
                CASE status
                    WHEN 'in_progress' THEN 1
                    WHEN 'pending' THEN 2
                    WHEN 'completed' THEN 3
                    WHEN 'cancelled' THEN 4
                END
            ");

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
            'teamMembers', 'displayLimit', 'extraMembers', 'completedTasks', 
            'totalTasks', 'progress'));
    }

    public function store(Request $request, Project $project){
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'deadline' => 'nullable|date',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,in_progress',

            // Assigned members
            'members' => 'nullable|array',
            'members.*' => 'exists:users,id',
        ]);

        $validated['project_id'] = $project->id;
        $validated['image'] = TaskImageHelper::randomPlaceholder(); 
        $validated['leader_id'] = auth()->id();

        $task = Task::create($validated);
        $task->users()->sync($request->members ?? []);

        // $task->load('users');

        // dd(
        //     $task->users->pluck('id'),
        //     auth()->id()
        // );

        foreach ($task->project->users as $member) {

            if ($member->id == auth()->id()) {
                $member->notify(
                    new ActivityNotification(
                        title: 'Task Created',
                        message: 'You created the task "'.$task->title.'".',
                        type: 'task_created',
                        projectId: $project->id,
                        taskId: $task->id,
                    )
                );
                continue;
            }

            $member->notify(
                new ActivityNotification(
                    title: 'Task Created',
                    message: auth()->user()->name.' created the task "'.$task->title.'".',
                    type: 'task_created',
                    projectId: $project->id,
                    taskId: $task->id,
                )
            );
        }

        $task->load('users');

        return redirect()
            ->back()
            ->with('success', __('main.toast.task-created'));
    }

    public function update(Request $request, Task $task){

        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],

            'priority' => ['required', 'in:low,medium,high'],
            'status' => ['required', 'in:pending,in_progress,completed,cancelled'],

            'deadline' => ['nullable', 'date'],

            'members' => ['array'],
            'members.*' => ['exists:users,id'],

            'go_collab_enabled' => ['required', 'boolean'],
            'go_collab_description' => ['nullable', 'string'],
            'go_collab_limit' => ['nullable', 'integer', 'min:1'],
            'go_collab_reward' => ['nullable', 'integer', 'min:0'],

            'collaborators' => ['array'],
            'collaborators.*.id' => ['exists:users,id'],

            'image' => 'nullable|image|max:4096',
        ]);

        if ($request->hasFile('image')) {
            if ($task->image &&
                Storage::disk('public')->exists($task->image)) {
                Storage::disk('public')->delete($task->image);
            }
            $validated['image'] = $request
                ->file('image')
                ->store('tasks', 'public');
        }

        $task->update([
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'priority' => $validated['priority'],
            'status' => $validated['status'],
            'deadline' => $validated['deadline'] ?? null,

            'is_completed' => $validated['status'] === 'completed',

            'go_collab_enabled' => $validated['go_collab_enabled'],
            'go_collab_description' => $validated['go_collab_description'] ?? null,
            'go_collab_limit' => $validated['go_collab_limit'] ?? null,
            'go_collab_reward' => $validated['go_collab_reward'] ?? 0,

            'image' => $validated['image'] ?? $task->image,
        ]); 

        // Cek member keseluruhan (assigned member)
        $task->users()->sync(
            $validated['members'] ?? []
        );

        // Cek member collaborator 
        $pivot = []; 
        $enabled = $validated['go_collab_enabled'];

        \Log::info($validated['collaborators'] ?? 'NOT SENT');

        if ($enabled) {
            $pivot = [];
            foreach ($validated['collaborators'] ?? [] as $user) {
                $existing = $task->collaborators()
                    ->where('user_id', $user['id'])
                    ->first();
                if ($existing) {
                    $pivot[$user['id']] = [
                        'status' => $existing->pivot->status,
                        'reward_earned' => $existing->pivot->reward_earned,
                        'joined_at' => $existing->pivot->joined_at,
                        'completed_at' => $existing->pivot->completed_at,
                    ];
                } else {
                    $pivot[$user['id']] = [
                        'status' => 'pending',
                        'reward_earned' => 0,
                        'joined_at' => now(),
                        'completed_at' => null,
                    ];
                }
            }
            if ($enabled && array_key_exists('collaborators', $validated)) {
                // Jaga supaya enggak ada bug collaborator ilang waktu edit go collab details 
                $task->collaborators()->sync($pivot);
            }
        } else {
            $task->collaborators()->detach();
        }

        $task->load('users');

        foreach ($task->project->users as $member) {

            if ($member->id == auth()->id()) {
                $member->notify(
                    new ActivityNotification(
                        title: 'Task Updated',
                        message: 'You updated the task "'.$task->title.'".',
                        type: 'task_updated',
                        projectId: $task->project_id,
                        taskId: $task->id,
                    )
                );
                continue;
            }

            $member->notify(
                new ActivityNotification(
                    title: 'Task Updated',
                    message: auth()->user()->name.' updated the task "'.$task->title.'".',
                    type: 'task_updated',
                    projectId: $task->project_id,
                    taskId: $task->id,
                )
            );
        }

        return response()->json([
            'success' => true
        ]);
    }
}