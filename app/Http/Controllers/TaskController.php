<?php

namespace App\Http\Controllers;

use App\Task;
use App\User;
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
        $tasksInBacklog = Task::with('project')->where('status', '=', 'backlog')->get();
        $tasksInProgress = Task::with('project')->where('status', '=', 'in_progress')->get();
        $tasksCompleted = Task::with('project')->where('status', '=', 'completed')->get();

        return view('tasks.index', compact('tasksInBacklog', 'tasksInProgress', 'tasksCompleted'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $users = User::all();
        return view('tasks.create', compact('users'));
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
            'user_id' => request('user_id'),
            'project_id' => request('project_id'),
            'name' => request('name'),
            'description' => request('description'),
            'start_date' => request('start_date'),
            'due_date' => request('due_date'),
            'status' => request('status'),
            'priority' => request('priority')
        ]);

        return redirect($task->path())
            ->with('flash', 'The task has been created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show($projectID, Task $task)
    {
        $users = User::all();

        return view('tasks.show', [
            'task' => $task,
            'comments' => $task->comments()->paginate(10)
        ], compact('users'));
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
     * @param  \Illuminate\Http\Request $request
     * @param  \App\Task $task
     * @return void
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function update(Request $request, Task $task)
    {
        $this->authorize('update', $task);

        $task->update([
            'name' => request('title'),
            'description' => request('body'),
            'start_date' => request('startDate'),
            'due_date' => request('dueDate'),
            'status' => request('status'),
            'priority' => request('priority'),
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param $project
     * @param  \App\Task $task
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy($project, Task $task)
    {
        $this->authorize('update', $task);

        $task->delete();

        if(request()->wantsJson()) {
            return response([], 204);
        }

        return redirect('/projects/'.$project);
    }
}
