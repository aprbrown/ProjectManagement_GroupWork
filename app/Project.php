<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];
//    protected $with = ['tasks'];
    protected $dates = [
        'start_date',
        'due_date'
    ];

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

    public function creator() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
