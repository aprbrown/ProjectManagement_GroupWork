<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];

    public function path() {
        return "/projects/{$this->project->slug}/tasks/{$this->id}";
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function creator() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function addComment($comment)
    {
        $this->comments()->create($comment);
    }
}
