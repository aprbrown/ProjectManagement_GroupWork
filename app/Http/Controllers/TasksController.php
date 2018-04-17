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

    public function store(Project $project) {
        $project->addTask([
            'user_id' => auth()->id(),
            'name' => request('name'),
            'status' => request('status'),
            'start_date' => request('start_date'),
            'due_date' => request('due_date'),
            'priority' => request('priority'),
            'description' => request('description')

        ]);
    }
}
