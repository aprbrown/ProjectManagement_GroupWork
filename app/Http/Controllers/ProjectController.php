<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
use Illuminate\Filesystem\Cache;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $projectsInBacklog = Project::where('status', '=', 'backlog')->get();
        $projectsInProgress = Project::where('status', '=', 'in_progress')->get();
        $projectsCompleted = Project::where('status', '=', 'completed')->get();

        return view('projects.index', compact('projectsInBacklog', 'projectsInProgress', 'projectsCompleted'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $request->user()->authorizeRoles('admin', 'project_manager');
        return view('projects.create');

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $slug = str_slug(request('name'),"-");

        $this->validate($request, [
            'name' => 'required',
            'description' => 'required',
            'status' => 'required',
            'start_date' => 'required',
            'due_date' => 'required'
        ]);

        $project = Project::create([
            'user_id' => auth()->id(),
            'name' => request('name'),
            'slug' => $slug,
            'description' => request('description'),
            'start_date' => request('start_date'),
            'due_date' => request('due_date'),
            'status' => request('status')
        ]);

        \Cache::flush();
        return redirect($project->path())->with('flash', 'The project has been created');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        return view('projects.show', compact('project'));
    }

    public function chart(Project $project)
    {
        $tasks = Task::with('project')->where('project_id' ,'=', $project->id)->get();
        return view('projects.chart', compact('tasks', 'project'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $slug = str_slug(request('title'),"-");

        $project->update([
            'name' => request('title'),
            'description' => request('body'),
            'start_date' => request('startDate'),
            'due_date' => request('dueDate'),
            'status' => request('status'),
            'slug' => $slug
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project $project
     * @return \Illuminate\Http\Response
     * @throws \Exception
     */
    public function destroy(Project $project)
    {
        $this->authorize('update', $project);

        $project->delete();

        if(request()->wantsJson()) {
            return response([], 204);
        }

        return redirect('/projects/');
    }
}
