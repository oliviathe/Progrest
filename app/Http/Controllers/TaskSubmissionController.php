<?php

namespace App\Http\Controllers;

use App\Models\Task;
use App\Models\TaskSubmission;
use App\Notifications\ActivityNotification;
use Illuminate\Http\Request;

class TaskSubmissionController extends Controller{
    public function store(Request $request, Task $task){

        // Jaga supaya cuma user yang terlibat sebagai kolabolator internal task aja 
        abort_unless(
            $task->users->contains(auth()->id()),
            403
        );

        $request->validate([
            'proof_image' => 'nullable|image|max:5120',
            'proof_link'  => 'nullable|url|max:2048',
            'notes'       => 'nullable|string|max:1000',
        ]);

        if (
            !$request->hasFile('proof_image') &&
            blank($request->proof_link)
        ) {
            return back()->withErrors([
                'proof_image' => 'Upload an image or provide a link.',
            ]);
        }

        $imagePath = null;

        if ($request->hasFile('proof_image')) {
            $imagePath = $request
                ->file('proof_image')
                ->store('task-submissions', 'public');
        }

        if ($task->submission) {
            return response()->json([
                'message' => 'This task already has a pending submission.'
            ], 409);
        }

        TaskSubmission::create([
            'task_id'       => $task->id,
            'submitted_by'  => auth()->id(),
            'proof_image'   => $imagePath,
            'proof_link'    => $request->proof_link,
            'notes'         => $request->notes,
            'status'        => 'pending',
        ]);

        return back()->with(
            'success',
            'Task submitted for review.'
        );
    }

    public function submit(Request $request, Task $task){
        $user = auth()->user();
        abort_unless(
            $task->users()->where('users.id', $user->id)->exists(),
            403,
            'You are not assigned to this task.'
        );

        if ($task->activeSubmission 
            && $task->activeSubmission->status === 'pending') {
            return response()->json([
                'message' => 'A submission already exists for this task.'
            ], 422);
        }

        $validated = $request->validate([
            'proof_image' => [
                'nullable',
                'image',
                'max:4096',
            ],
            'proof_link' => [
                'nullable',
                'url',
                'max:255',
            ],
            'notes' => [
                'nullable',
                'string',
            ],
        ]);

        if (
            empty($validated['proof_image']) &&
            empty($validated['proof_link'])
        ) {
            return response()->json([
                'message' => 'Please provide either a proof image or a proof link.'
            ], 422);
        }

        // Store proof image

        $proofImage = null;

        if ($request->hasFile('proof_image')) {
            $proofImage = $request
                ->file('proof_image')
                ->store('task-submissions', 'public');
        }

        // Create submission

        $submission = TaskSubmission::create([
            'task_id' => $task->id,
            'user_id' => $user->id,

            'proof_image' => $proofImage,
            'proof_link' => $validated['proof_link'] ?? null,
            'notes' => $validated['notes'] ?? null,

            'status' => 'pending',
        ]);

        $task->update([
            'status' => 'pending',
        ]);

        // Notify project leader

        if ($task->project->leader_id !== $user->id) {

            $task->project->leader->notify(
                new ActivityNotification(
                    title: 'Task Submission',
                    message: $user->name .
                        ' submitted "' .
                        $task->title .
                        '" for review.',
                    type: 'task_submission',
                    projectId: $task->project_id,
                    taskId: $task->id,
                )
            );
        }

        return response()->json([
            'success' => true,
            'submission' => $submission,
        ]);
    }
}
