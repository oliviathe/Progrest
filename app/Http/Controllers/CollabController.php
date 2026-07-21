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

    public function join(Project $project)
{
    if ($project->users()->whereKey(auth()->id())->exists()) {
        return redirect()
            ->route('projects.index')
            ->with('info', 'You have already joined this project.');
    }

    if (
        $project->capacity &&
        $project->users()->count() >= $project->capacity
    ) {
        return redirect('/collab')
            ->with('error', 'This collaboration is already full.');
    }

    $project->users()->syncWithoutDetaching(auth()->id());

    return redirect()
        ->route('projects.index')
        ->with('success', 'Successfully joined the collaboration!');
}
}