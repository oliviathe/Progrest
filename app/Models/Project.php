<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 

class Project extends Model
{
    use HasFactory; 
    protected $fillable = ['leader_id', 'title', 'description', 'icon', 'accent', 'deadline']; 

    protected $casts = [
        'deadline' => 'date'
    ]; 

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

        return (int) now()->diffInDays($this->deadline, false);
    }

    public function tasks(){
        return $this->hasMany(Task::class); 
    }

    public function getProgressAttribute(){
        $completed = $this->tasks()->where('is_completed', true)->count(); 
        $total = $this->tasks()->count(); 

        return $progress = $total > 0
            ? round(($completed / $total) * 100)
            : 0; 
    }

    public function getCompletedTasks(){
        return $this->hasMany(Task::class)->where('is_completed', true); 
    }
}
