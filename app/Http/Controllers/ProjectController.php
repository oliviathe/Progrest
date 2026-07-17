<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Project; 
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function __construct(){
        $this->middleware('auth');
    }

    public function index(Request $request){
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

        $sort = $request->get('sort', 'recent'); 
        $search = $request->get('search'); 
        $direction = $request->get('direction', 'desc'); 

        $projects = Project::where(function ($query) {
            $query->where('leader_id', auth()->id())
                ->orWhereHas('users', function ($q) {
                    $q->where('user_id', auth()->id());
                });
        });

        if ($search) {
            $projects->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            });
        }

        match ($sort) {
            'alphabetical' =>
                $projects->orderBy('title', $direction),
            default =>
                $projects->orderBy('deadline', $direction),
        };

        $projects = $projects->get();

        if ($sort === 'progress') {
            $projects = $direction === 'asc'
                ? $projects->sortBy('progress')
                : $projects->sortByDesc('progress');
        }

        return view('projects.index', compact('menu', 'projects')); 
    }

    public function store(Request $request){
        $user_id = auth()->id(); 

        $validated = $request->validate([
            'title' => 'required|string|max:15',
            'description' => 'required|string|max:255',
            'accent' => 'required|string', 
            'icon' => 'required|string', 
            'deadline' => 'nullable|date', 
            'members' => 'nullable|array', 
            'members.*' => 'exists:users,id',
        ], 
        [
            'title.required' => 'Project title is required.',
            'title.max' => 'Project title cannot exceed 15 characters.',
            'description.required' => 'Project description is required.', 
            'description.max' => 'Description cannot exceed 255 characters.',
            'deadline.date' => 'Please choose a valid date.',
            'members.array' => 'Invalid member list.',
            'members.*.exists' => 'One or more selected users do not exist.',
        ]
        );

        $project = Project::create([
            'leader_id' => $user_id,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'accent' => $validated['accent'] ?? "#0EA5A4", 
            'icon' => $validated['icon'] ?? "folder-git-2", 
            'deadline' => $validated['deadline'] ?? null, 
            'progress' => 0
        ]);

        $memberIds = $validated['members'] ?? [];

        // Tambain project leader
        $memberIds[] = $user_id;
        $memberIds = array_unique($memberIds);

        $project->users()->syncWithoutDetaching($memberIds);

        return redirect()->route('projects.index')->with('success', 'Project created successfully!');
    }
}