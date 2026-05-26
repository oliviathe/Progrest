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
                ->orWhereHas('members', function ($q) {
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

            'progress' =>
                $projects->orderBy('progress', $direction),

            default =>
                $projects->orderBy('updated_at', $direction),
        };

        $projects = $projects->get(); 
        return view('projects.index', compact('menu', 'projects')); 
    }

    public function store(Request $request){
        $user_id = auth()->id(); 

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'accent' => 'required|string', 
            'icon' => 'required|string', 
            'deadline' => 'nullable|date'
        ]);

        $project = Project::create([
            'leader_id' => $user_id,
            'title' => $validated['title'],
            'description' => $validated['description'] ?? null,
            'accent' => $validated['accent'] ?? "#0EA5A4", 
            'icon' => $validated['icon'] ?? "folder-git-2", 
            'deadline' => $validated['deadline'] ?? null, 
            'progress' => 0
        ]);

        $project->members()->syncWithoutDetaching([$user_id]); // add member + supaya enggak ada duplicated member juga 

        return redirect()->route('projects.index')->with('success', 'Project created successfully!');
    }

    public function show(Project $project){
        $user_id = auth()->id(); 

        $isLeader = $project->leader_id === $user_id; 
        $isMember = $project->members()->where('user_id', $user_id)->exists(); 

        abort_if(!($isLeader || $isMember), 403); 

        return view('projects.show', compact('project')); 
    }
}