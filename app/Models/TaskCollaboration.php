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
}