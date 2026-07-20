<?php

namespace App\Models;

use App\Models\TaskCollaboration;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'status',
        'deadline',
        'is_completed',
        'priority',
        'image', 
        'project_id',
        'completed_at',
        'go_collab_enabled',
        'go_collab_description',
        'go_collab_limit',
        'go_collab_reward'
    ];

    protected $casts = [
        'deadline' => 'date',
        'is_completed' => 'boolean',
        'completed_at' => 'datetime',
    ];

    /**
     * Keep completed_at in sync with completion state, wherever a task is saved.
     * Marking complete stamps the time (without overwriting an existing stamp);
     * reopening a task clears it.
     */
    protected static function booted(): void
    {
        static::saving(function (Task $task) {
            if ($task->isDirty('is_completed') || $task->isDirty('status')) {
                $isDone = $task->is_completed || $task->status === 'completed';

                $task->completed_at = $isDone
                    ? ($task->completed_at ?? now())
                    : null;
            }
        });
    }

    public function project(){
        return $this->belongsTo(Project::class); 
    }

    public function users(){
        return $this->belongsToMany(User::class); 
    }

    public function collaborations(){
        return $this->hasMany(TaskCollaboration::class);
    }

    public function collaborators()
    {
        return $this->belongsToMany(User::class, 'task_collaborations')
                    ->withPivot([
                        'status',
                        'reward_earned',
                        'joined_at',
                        'completed_at'
                    ])
                    ->withTimestamps();
    }
}
