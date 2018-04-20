<?php

namespace App\Http\Controllers;

use App\Project;
use App\Task;
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
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
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
            'due_date' => 'required',
            'status' => 'required'
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

        return redirect($project->path());
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Project  $project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        //
    }
}
