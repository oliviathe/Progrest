<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Project;
use Illuminate\Support\Facades\Auth;

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

    $projects = auth()->user()
        ->projects()
        ->with([
            'leader',
            'tasks'
        ])
        ->withCount('users')
        ->latest()
        ->paginate(9);

    return view('collab.index', compact(
        'menu',
        'projects'
    ));
}
}