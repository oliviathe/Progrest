<?php

namespace App\Models;

use App\Models\Project;
// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

// #[Fillable(['username', 'name', 'email', 'password'])]
// #[Hidden(['password', 'remember_token'])]

class User extends Authenticatable
{
    use HasFactory, Notifiable;
    protected $fillable = [
        'username',
        'name',
        'email',
        'password',
        'avatar',
        'banner',
        'about',
        'more_about',
        'city',
        'country',
        'linkedin',
        'hide_email',
    ];

    protected function casts(): array{
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'hide_email' => 'boolean',
        ];
    }

    public function getAvatarUrlAttribute(): string
    {
        if (! $this->avatar) {
            return asset('images/profile.jpg');
        }

        return Str::startsWith($this->avatar, ['http', 'data:'])
            ? $this->avatar
            : asset('storage/' . $this->avatar);
    }

    public function getBannerUrlAttribute(): string
    {
        if (! $this->banner) {
            return asset('images/Checker_BG.png');
        }

        return Str::startsWith($this->banner, ['http', 'data:'])
            ? $this->banner
            : asset('storage/' . $this->banner);
    }

    public function ledProjects(){
        return $this->hasMany(Project::class, 'leader_id');
    }

    public function projects(){
        return $this->belongsToMany(Project::class); 
    }

    public function tasks(){
        return $this->belongsToMany(Task::class); 
    }

    public function taskCollaborations(){
        return $this->hasMany(TaskCollaboration::class);
    }

    public function collaborativeTasks(){
        return $this->belongsToMany(Task::class, 'task_collaborations')
                    ->withPivot([
                        'status',
                        'reward_earned',
                        'joined_at',
                        'completed_at'
                    ])
                    ->withTimestamps();
    }
}
