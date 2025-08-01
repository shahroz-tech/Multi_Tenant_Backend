<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Team extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = [];

    public function users(){
        return $this->belongsToMany(User::class,'team_user')->withPivot('role')->withTimestamps();
    }
    public function owner(){
        return $this->belongsTo(User::class);
    }
    public function projects(){
        return $this->hasMany(Project::class);
    }
}
