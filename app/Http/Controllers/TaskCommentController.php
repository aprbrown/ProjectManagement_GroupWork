<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

class TaskCommentController extends Controller
{
    /**
     * TaskCommentController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Task $task)
    {
        $task->addComment([
            'body' => request('body'),
            'user_id' => auth()->id()
        ]);

        return back();
    }
}
