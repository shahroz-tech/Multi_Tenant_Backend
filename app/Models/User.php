<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Cashier\Billable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasApiTokens, Billable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function teams(){
        return $this->belongsToMany(Team::class,'team_user')->withPivot('role')->withTimestamps();
    }

    public function ownedTeams(){
        return $this->hasMany(Team::class);
    }

    public function tasks(){
        return $this->belongsToMany(Task::class,'task_user');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function activitylogs(){
        return $this->hasMany(ActivityLog::class);
    }

    public function projects(){
        return $this->hasMany(Project::class);
    }
}
