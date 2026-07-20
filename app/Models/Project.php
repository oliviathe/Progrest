<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Project extends Model
{
    use HasFactory; 
    protected $fillable = ['leader_id','title','description','icon','cover_image','capacity','accent','deadline', 'cover_image'];

    protected $casts = [
        'deadline' => 'date'    
    ];
    
    protected $appends = [
        'cover_url',
    ];

    public function getCoverUrlAttribute(): string
{
    if (! $this->cover_image) {
        if ($this->cover_image) {
            return asset('storage/' . $this->cover_image);
        }
        return asset('images/project-cover.jpg');
    }

    return Str::startsWith($this->cover_image, ['http', 'data:'])
        ? $this->cover_image
        : asset('storage/'.$this->cover_image);
}

    public function leader(){
        return $this->belongsTo(User::class, 'leader_id');
    }

    public function users(){
        return $this->belongsToMany(User::class); 
    }

    public function getDaysRemainingAttribute(){
        if (!$this->deadline) {
            return null;
        }

        return now()
            ->startOfDay()
            ->diffInDays($this->deadline->copy()->startOfDay(), false);
    }

    public function tasks(){
        return $this->hasMany(Task::class); 
    }

    public function getProgressAttribute()
    {
        $total = $this->tasks->count();
    
        if ($total == 0) {
            return 0;
        }
    
        return round(
            $this->tasks
                ->where('is_completed', true)
                ->count()
            / $total * 100
        );
    }

    public function getCompletedTasks(){
        return $this->hasMany(Task::class)->where('is_completed', true); 
    }

    public function collaborations(){
        return $this->hasManyThrough(
            TaskCollaboration::class,
            Task::class
        );
    }
}
