<?php

namespace App;

use function foo\func;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $guarded = [];
    protected $with = ['creator', 'comments'];
    protected $dates = [
        'start_date',
        'due_date'
    ];

    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope('commentCount', function($builder) {
            $builder->withCount('comments');
        });
    }

    public function path() {
        return "/projects/{$this->project->slug}/tasks/{$this->id}";
    }

    public function comments() {
        return $this->hasMany(Comment::class)
            ->with('owner');
    }

    public function getCommentCountAttribute() {
        return $this->comments()->count();
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

    public function allTasks()
    {

    }
}
