@extends('layouts.app')

@section('content')
    @if (auth()->check())
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <div class="card mb-5">
                        <div class="card-header d-flex">
                            <div class="h2 mr-auto">{{ $project->name }} </div>
                            <form action="{{ $project->path().'/chart/' }}">
                                <input class="btn btn-outline-primary" type="submit" value="Chart View">
                            </form>
                        </div>

                        <div class="card-body">
                            <div>
                                {{ $project->description }}
                            </div>
                        </div>

                        <div class="card-footer d-flex">
                            <span class="dropdown mr-auto p-2">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @switch($project->status)
                                        @case('backlog')
                                        Backlog
                                        @break

                                        @case('in_progress')
                                        In Progress
                                        @break

                                        @case('completed')
                                        Completed
                                        @break

                                        @default
                                        <span>Unknown Status</span>
                                    @endswitch
                                </button>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">Backlog</a>
                                    <a class="dropdown-item" href="#">In Progress</a>
                                    <a class="dropdown-item" href="#">Completed</a>
                                </div>
                            </span>
                        </div>

                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-header d-flex flex-column">
                            <span class="p-2">Manager: <a href="/profiles/{{ $project->creator->name }}">{{ $project->creator->name }}</a></span>
                            <span class="p-2">Status:
                                @switch($project->status)
                                    @case('backlog')
                                    Backlog
                                    @break

                                    @case('in_progress')
                                    In Progress
                                    @break

                                    @case('completed')
                                    Completed
                                    @break

                                    @default
                                    <span>Unknown Status</span>
                                @endswitch
                            </span>
                                <span class="p-2">
                                    Start Date: {{ $project->start_date->toFormattedDateString() }}
                                    ({{ $project->start_date->diffForHumans() }})
                                </span>
                                <span class="p-2">
                                    Due Date: {{ $project->due_date->toFormattedDateString() }}
                                    ({{ $project->due_date->diffForHumans() }})
                                </span>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-header bg-danger d-flex justify-content-between">
                            <div class="h2">Backlog</div>
                            <div class="h2">
                                <button class="btn btn-dark" type="button" data-toggle="collapse" data-target="#backlog"
                                        aria-expanded="false" aria-controls="backlog">
                                    {{ $project->tasks->where('status', '=', 'backlog')->count() }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="collapse" id="backlog">
                        @foreach($project->tasks->where('status', '=', 'backlog') as $task)
                            <div class="card mb-3">
                                <div class="card-header">
                                    <a href="{{ $task->path() }}">
                                        {{ $task->name }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-header bg-warning d-flex justify-content-between">
                            <div class="h2">In Progress</div>
                            <div class="h2">
                                <button class="btn btn-dark" type="button" data-toggle="collapse" data-target="#in_progress"
                                        aria-expanded="false" aria-controls="in_progress">
                                    {{ $project->tasks->where('status', '=', 'in_progress')->count() }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="collapse" id="in_progress">
                        @foreach($project->tasks->where('status', '=', 'in_progress') as $task)
                            <div class="card mb-3">
                                <div class="card-header">
                                    <a href="{{ $task->path() }}">
                                        {{ $task->name }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>

                </div>

                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-header bg-success d-flex justify-content-between">
                            <div class="h2">Completed</div>
                            <div class="h2">
                                <button class="btn btn-dark" type="button" data-toggle="collapse" data-target="#completed"
                                        aria-expanded="false" aria-controls="completed">
                                    {{ $project->tasks->where('status', '=', 'completed')->count() }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="collapse" id="completed">
                        @foreach($project->tasks->where('status', '=', 'completed') as $task)
                            <div class="card mb-3">
                                <div class="card-header">
                                    <a href="{{ $task->path() }}">
                                        {{ $task->name }}
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @else
        @include('auth.login')
    @endif
@endsection
