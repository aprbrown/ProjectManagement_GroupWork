<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'tasks';
    protected $fillable = ['status', 'start_date', 'due_date', 'priority'];
    protected $guarded = [];

    public function path() {
        return '/tasks/' . $this->id;
    }

    public function comments() {
        return $this->hasMany(TaskComment::class);
    }

    public function taskCreator() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function addComment($comment) {
        $this->comments()->create($comment);
    }

    public function commentCount() {
        return $this->hasMany(TaskComment::class)->count();
    }
}
