<?php

namespace App\Http\Controllers;

use App\Task;
use Illuminate\Http\Request;

/**
 * Class TaskController
 * @package App\Http\Controllers
 */
class TaskController extends Controller
{
    /**
     * TaskController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tasksInBacklog = Task::where('status', '=', 'backlog')->get();
        $tasksInProgress = Task::where('status', '=', 'in_progress')->get();
        $tasksCompleted = Task::where('status', '=', 'completed')->get();

        return view('tasks.index', compact('tasksInBacklog', 'tasksInProgress', 'tasksCompleted'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('tasks.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'project_id' => 'required|exists:projects,id',
            'name' => 'required',
            'description' => 'required',
            'status' => 'required',
            'priority' => 'required',
            'start_date' => 'required',
            'due_date' => 'required'
        ]);

        $task = Task::create([
            'user_id' => auth()->id(),
            'project_id' => request('project_id'),
            'name' => request('name'),
            'description' => request('description'),
            'start_date' => request('start_date'),
            'due_date' => request('due_date'),
            'status' => request('status'),
            'priority' => request('priority')
        ]);

        return redirect($task->path());
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show($projectID, Task $task)
    {


        return view('tasks.show', compact('task'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        //
    }
}
