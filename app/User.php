<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * @return string
     */
    public function getRouteKeyName()
    {
        return 'name';
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function tasksInBacklog()
    {
        return $this->hasMany(Task::class)->where('status', '=', 'backlog');
    }

    public function backlogCount()
    {
        return $this->tasksInBacklog()->count();
    }

    public function tasksInProgress()
    {
        return $this->hasMany(Task::class)->where('status', '=', 'in_progress');
    }

    public function inProgressCount()
    {
        return $this->tasksInProgress()->count();
    }

    public function tasksCompleted()
    {
        return $this->hasMany(Task::class)->where('status', '=', 'completed');
    }

    public function completedCount()
    {
        return $this->tasksCompleted()->count();
    }
}
