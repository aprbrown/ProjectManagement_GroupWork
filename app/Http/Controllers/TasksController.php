<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Project;

class TasksController extends Controller
{
    public function index()
    {
        $tasks = Task::latest()->get();
        return view('tasks.index', compact('tasks'));
    }

    public function show(Task $task)
    {
        return view('tasks.show', compact('task'));
    }
}
