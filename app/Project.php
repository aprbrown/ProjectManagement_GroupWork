<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    use RecordsActivity;

    protected $guarded = [];
//    protected $with = ['tasks'];
    protected $dates = [
        'start_date',
        'due_date'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($project) {
            $project->tasks->each->delete();
        });
    }

    public function path() {
        return "/projects/{$this->slug}";
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function taskCount()
    {
        return $this->hasMany(Task::class)->count();
    }

    public function tasksForGantt()
    {
        return $this->hasMany(Task::class)->select(['name', 'start_date', 'due_date']);
    }

    public function creator() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
