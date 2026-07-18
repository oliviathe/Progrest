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
        'last_login_date',
        'current_streak',
        'best_streak',
        'points',
        'highest_points',
    ];

    protected function casts(): array{
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'hide_email' => 'boolean',
            'last_login_date' => 'date',
            'current_streak' => 'integer',
            'best_streak' => 'integer',
            'points' => 'integer',
            'highest_points' => 'integer',
        ];
    }

    /**
     * Add points to the current balance and raise the all-time peak if the
     * new balance beats it.
     */
    public function awardPoints(int $amount): void
    {
        if ($amount <= 0) {
            return;
        }

        $this->points = ($this->points ?? 0) + $amount;
        $this->highest_points = max($this->highest_points ?? 0, $this->points);

        $this->save();
    }

    /**
     * Record a login and update the consecutive-day streak.
     *
     * Same day  -> no change (logging in twice today is still one day).
     * Yesterday -> streak continues.
     * Older/never -> streak restarts at 1.
     */
    public function recordLogin(): void
    {
        $today = now()->startOfDay();
        $last = $this->last_login_date?->startOfDay();

        if ($last && $last->equalTo($today)) {
            return;
        }

        $this->current_streak = ($last && $last->equalTo($today->copy()->subDay()))
            ? $this->current_streak + 1
            : 1;

        $this->best_streak = max($this->best_streak ?? 0, $this->current_streak);
        $this->last_login_date = $today;

        $this->save();
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
