<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $guarded = [];

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
