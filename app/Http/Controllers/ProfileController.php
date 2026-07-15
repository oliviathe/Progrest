<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
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
            'username'   => 'required|string|max:30',
            'name'       => 'required|string|max:255',
            'about'      => 'nullable|string|max:2000',
            'more_about' => 'nullable|string|max:5000',
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

        // PHOTO - store the uploaded image directly in the database
        if ($request->hasFile('avatar')) {
            $user->avatar = $this->encodeImage($request->file('avatar'));
        }

        // BANNER - store the uploaded image directly in the database
        if ($request->hasFile('banner')) {
            $user->banner = $this->encodeImage($request->file('banner'));
        }

        $user->save();

        return redirect('/profile')->with('success', 'Profile updated successfully!');
    }

    /**
     * Encode an uploaded image as a base64 data URI for database storage.
     */
    private function encodeImage(UploadedFile $file): string
    {
        return 'data:' . $file->getMimeType() . ';base64,'
            . base64_encode(file_get_contents($file->getRealPath()));
    }
}
