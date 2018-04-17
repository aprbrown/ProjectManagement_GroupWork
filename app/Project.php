<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'projects';
    protected $fillable = ['status', 'start_date', 'due_date'];

    public function path() {
        return '/projects/' . $this->id;
    }

    public function tasks() {
        return $this->hasMany(Task::class);
    }

    public function projectManager() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function statusCount($status) {
        return $this->hasMany(Task::class)->where('status', '=', $status)->count();
    }

    public function tasksInBacklog() {
        return $this->hasMany(Task::class)->where('status', '=', 'backlog');
    }

    public function tasksInProgress() {
        return $this->hasMany(Task::class)->where('status', '=', 'in_progress');
    }

    public function tasksCompleted() {
        return $this->hasMany(Task::class)->where('status', '=', 'completed');
    }


}
