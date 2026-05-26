<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model; 

class Project extends Model
{
    use HasFactory; 
    protected $fillable = ['leader_id', 'title', 'description', 'progress', 'icon', 'accent', 'deadline']; 

    public function leader(){
        return $this->belongsTo(User::class, 'leader_id');
    }
    public function members(){
        return $this->belongsToMany(User::class); 
    }
    public function getDaysRemainingAttribute(){
        if (!$this->deadline) {
            return null;
        }

        return (int) now()->diffInDays($this->deadline, false);
    }
}
