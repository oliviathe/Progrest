<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use App\Models\Task;

class CollabController extends Controller
{
    public function index()
{
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

    $projects = Project::with([
            'leader',
            'users'
        ])
        ->withCount('users')
        ->latest()
        ->paginate(9);

    return view('collab.index', compact('menu', 'user', 'projects'));
}
    public function create(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'required|string',
        'deadline' => 'nullable|date',
        'priority' => 'required',
        'capacity' => 'required|integer|min:2',
        'reward' => 'required|integer|min:0',
        'cover_image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
    ]);

    $icons = [
        'folder-git',
        'folder-kanban',
        'folder-code',
        'folder-open',
        'folder-search',
        'folder-sync',
    ];

    $coverImage = null;

    if ($request->hasFile('cover_image')) {

        $coverImage = $request
            ->file('cover_image')
            ->store('collab', 'public');

    }

    $project = Project::create([
        'leader_id' => auth()->id(),
        'title' => $request->title,
        'description' => $request->description,
        'deadline' => $request->deadline,
        'progress' => 0,
        'accent' => '#2E7D32',
        'icon' => $icons[array_rand($icons)],
        'capacity' => $request->capacity,
        'reward' => $request->reward,
        'cover_image' => $coverImage,
    ]);

    // otomatis masuk member
    $project->users()->attach(auth()->id());

    // bikin task pertama
    Task::create([
        'project_id' => $project->id,
        'leader_id' => auth()->id(),
        'title' => $request->title,
        'description' => $request->description,
        'priority' => $request->priority,
        'status' => 'pending',
        'deadline' => $request->deadline,
        'image' => '/images/task-placeholder.png',
        'capacity' => $request->capacity,
        'reward' => $request->reward,
    ]);

    return redirect()
        ->route('projects.index')
        ->with('success','Collaboration created.');
}

    public function join(Project $project)
{
    if ($project->users()->count() >= $project->capacity) {

    return back()->with(
        'error',
        'Project is already full.'
    );

}

    $project->users()->syncWithoutDetaching([
        auth()->id()
        
        
    ]);

    return redirect()
        ->route('projects.index')
        ->with('success','You joined the collaboration.');
}
}