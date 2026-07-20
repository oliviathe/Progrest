<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;

class ProfileController extends Controller
{
    public function index() {

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

        $user = auth()->user();

        // Tasks helped / done (completed only)
        $tasksHelped = $user->tasks()
            ->where('is_completed', true)
            ->with('project')
            ->latest()
            ->get();

        // Tasks created / project lead
        $tasksCreated = Task::whereIn('project_id', $user->ledProjects()->pluck('id'))
            ->with('project')
            ->latest()
            ->get();

        $projectIds = $user->projects()->pluck('projects.id');

        // Points per task priority
        $priorityPoints = ['high' => 15, 'medium' => 10, 'low' => 5];

        $stats = [
            'projects_joined' => $projectIds->count(),
            'tasks_completed' => $tasksHelped->count(),
            // Other users who share projects with user
            'collaborations'  => User::where('id', '!=', $user->id)
                ->whereHas('projects', fn ($q) => $q->whereIn('projects.id', $projectIds))
                ->count(),
            'points'          => $tasksHelped->sum(fn ($task) => $priorityPoints[$task->priority] ?? 0),
        ];

        return view('profile.index', [
            'menu' => $menu,
            'projects' => $user->projects()->latest()->get(),
            'tasksHelped' => $tasksHelped,
            'tasksCreated' => $tasksCreated,
            'stats' => $stats,
        ]);
    }

    public function update(Request $request) {

        $user = auth()->user();

        foreach (['avatar' => 'main.toast.avatar', 'banner' => 'main.toast.banner'] as $field => $labelKey) {
            $file = $request->file($field);
            if ($file !== null && ! $file->isValid()) {
                return back()
                    ->withInput()
                    ->withErrors([$field => __('main.toast.file-too-large', ['label' => __($labelKey)])]);
            }
        }

        $validated = $request->validate([
            'username'   => 'required|string|max:30',
            'name'       => 'required|string|max:255',
            'about'      => 'nullable|string|max:200',
            'more_about' => 'nullable|string|max:2000',
            'city'       => 'nullable|string|max:255',
            'country'    => 'nullable|string|max:255',
            'linkedin'   => 'nullable|string|max:30',
            'hide_email' => 'nullable|boolean',
            'avatar'     => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:1024',
            'banner'     => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:2048',
        ]);

        $user->username   = $validated['username'];
        $user->name       = $validated['name'];
        $user->about      = $validated['about'] ?? null;
        $user->more_about = $validated['more_about'] ?? null;
        $user->city       = $validated['city'] ?? null;
        $user->country    = $validated['country'] ?? null;
        $user->linkedin   = $validated['linkedin'] ?? null;
        $user->hide_email = $request->boolean('hide_email');

        if ($request->hasFile('avatar')) {
            $user->avatar = $this->encodeImage($request->file('avatar'));
        }

        if ($request->hasFile('banner')) {
            $user->banner = $this->encodeImage($request->file('banner'));
        }

        $user->save();

        return redirect('/profile')->with('success', __('main.toast.profile-updated'));
    }

    /**
     * encode and upload image as base64
     */
    private function encodeImage(UploadedFile $file): string
    {
        return 'data:' . $file->getMimeType() . ';base64,'
            . base64_encode(file_get_contents($file->getRealPath()));
    }
}
