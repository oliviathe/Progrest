<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;

class ProjectMemberController extends Controller
{
    public function search(Project $project, Request $request){

        $search = trim($request->query('q'));

        if ($search === '') {
            return response()->json([]);
        }

        $memberIds = $project->users()
            ->pluck('users.id')
            ->toArray();

        // Jangan masukin project leader juga 
        $memberIds[] = $project->leader_id;

        // Search users by name or email
        $users = User::query()
            ->where(function ($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            })
            ->whereNotIn('id', $memberIds)
            ->orderBy('name')
            ->limit(10)
            ->get([
                'id',
                'name',
                'email'
            ]);

        return response()->json($users);
    }
}
