<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TaskCollaboration extends Model
{
    protected $fillable = [
        'task_id',
        'user_id',
        'status',
        'reward_earned',
        'joined_at',
        'completed_at',
    ];

    protected $casts = [
        'joined_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Pay out a collaboration the moment it is marked completed:
     * stamp the finish time, copy the task's advertised reward into
     * reward_earned, then credit it to the collaborator's balance.
     */
    protected static function booted(): void
    {
        static::saving(function (TaskCollaboration $collaboration) {
            if (! $collaboration->isDirty('status') || $collaboration->status !== 'completed') {
                return;
            }

            $collaboration->completed_at ??= now();

            // Only set the reward if it hasn't already been recorded, so a
            // manually adjusted amount is never overwritten.
            if ((int) $collaboration->reward_earned === 0) {
                $collaboration->reward_earned = (int) ($collaboration->task?->go_collab_reward ?? 0);
            }
        });

        static::saved(function (TaskCollaboration $collaboration) {
            // wasChanged() is only true on the save that actually flipped the
            // status, so a completed row re-saved later is never paid twice.
            if ($collaboration->wasChanged('status') && $collaboration->status === 'completed') {
                $collaboration->user?->awardPoints((int) $collaboration->reward_earned);
            }
        });
    }
}