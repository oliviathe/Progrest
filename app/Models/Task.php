<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'title',
        'description',
        'accent',
        'icon',
        'status',
        'deadline',
        'is_completed', 
        'priority',
        'project_id',
    ]; 

    protected $casts = [
        'deadline' => 'date', 
        'is_completed' => 'boolean'
    ]; 

    public function project(){
        return $this->belongsTo(Project::class); 
    }

    public function users(){
        return $this->belongsToMany(User::class); 
    }
}
