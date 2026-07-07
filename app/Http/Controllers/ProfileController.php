<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Project;

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

        return view('profile.index', [
            'menu' => $menu,
            'projects' => $user->projects()->latest()->get()
        ]);
    }

    public function update(Request $request) {

        $user = auth()->user();

        $validated = $request->validate([
            'username'   => 'required|string|max:255',
            'name'       => 'required|string|max:255',
            'about'      => 'required|string|max:2000',
            'linkedin'   => 'nullable|string|max:255',
            'hide_email' => 'nullable|boolean',
            'avatar'     => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:4096',
            'banner'     => 'nullable|image|mimes:jpg,jpeg,png,webp,gif|max:8192',
        ]);

        $user->username   = $validated['username'];
        $user->name       = $validated['name'];
        $user->about      = $validated['about'] ?? null;
        $user->linkedin   = $validated['linkedin'] ?? null;
        $user->hide_email = $request->boolean('hide_email');

        // PHOTO — store the new upload and remove the previous local file
        if ($request->hasFile('avatar')) {
            $this->deleteStoredFile($user->avatar);
            $user->avatar = $request->file('avatar')->store('avatars', 'public');
        }

        // BANNER — store the new upload and remove the previous local file
        if ($request->hasFile('banner')) {
            $this->deleteStoredFile($user->banner);
            $user->banner = $request->file('banner')->store('banners', 'public');
        }

        $user->save();

        return redirect('/profile')->with('success', 'Profile updated successfully!');
    }

    private function deleteStoredFile(?string $path): void
    {
        if (! $path || str_starts_with($path, 'http')) {
            return;
        }

        Storage::disk('public')->delete($path);
    }
}
