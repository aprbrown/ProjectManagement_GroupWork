@extends('layouts.app')

@section('content')
    @if (auth()->check())
        <div class="container">
            <div class="row">
                <div class="col-md-8">
                    <project :attributes="{{ $project }}" inline-template v-cloak>
                        <div class="card mb-5">
                            <div class="card-header">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <div v-if="editing">
                                            <textarea class="form-control" v-model="title"></textarea>
                                        </div>

                                        <div class="h3" v-else v-text="title"></div>
                                    </div>

                                    <div class="justify-content-end">
                                        @can('update', $project)
                                            <ul class="navbar-nav ml-auto">
                                                <li class="nav-item dropdown">
                                                    <a id="optionsDropdown" class="nav-link dropdown-toggle ml-3" href="#"
                                                       role="button" data-toggle="dropdown" aria-haspopup="true"
                                                       aria-expanded="false" v-pre>
                                                        Options <span class="oi oi-cog"></span>
                                                    </a>

                                                    <div class="dropdown-menu" aria-labelledby="optionsDropdown">
                                                        <a class="dropdown-item" href="#"
                                                           @click="editing = true">
                                                            Edit Project
                                                        </a>

                                                        <a class="dropdown-item text-danger" href="#"
                                                           onclick="event.preventDefault();
                                                        document.getElementById('deleteProject').submit()">
                                                            Delete Project
                                                        </a>
                                                    </div>
                                                </li>
                                            </ul>

                                            <form id="deleteProject" action="{{ $project->path() }}" method="POST">
                                                {{ csrf_field() }}
                                                {{ method_field('DELETE') }}
                                            </form>
                                        @endcan
                                    </div>

                                </div>
                            </div>

                            <div class="card-body">
                                <div v-if="editing">
                                    <div class="form-group">
                                        <textarea class="form-control" v-model="body"></textarea>
                                    </div>
                                </div>

                                <div v-else v-text="body"></div>
                            </div>

                            <div class="card-footer d-flex flex-column">
                                <div class="row">
                                    <div class="p-2">
                                        <div v-if="editing">
                                            <label for="start_date">Current Start Date: {{ $project->start_date->toFormattedDateString() }}</label>
                                            <br>
                                            <input name="start_date" id="start_date" type="date"
                                                   value="{{ old('start_date') }}" placeholder="yyyy-mm-dd"  v-model="startDate">
                                        </div>

                                        <div v-else>
                                            Start Date: {{ $project->start_date->toFormattedDateString() }}
                                        </div>
                                    </div>

                                    <div class="p-2">
                                        <div v-if="editing">
                                            <label for="due_date">Current Due Date: {{ $project->due_date->toFormattedDateString() }}</label>
                                            <br>
                                            <input name="due_date" id="due_date" type="date" placeholder="yyyy-mm-dd"  v-model="dueDate">
                                        </div>

                                        <div v-else>
                                            Due Date: {{ $project->due_date->toFormattedDateString() }}
                                        </div>
                                    </div>

                                    <div class="p-2">
                                        <div v-if="editing">
                                            <select id="status" name="status" v-model="status">
                                                <option value="">Status...</option>
                                                <option value="backlog">Backlog</option>
                                                <option value="in_progress">In Progress</option>
                                                <option value="completed">Completed</option>
                                            </select>
                                        </div>

                                        <div v-else>
                                            Status:
                                            @if($project->start_date < now() && $project->status == 'backlog')
                                                <span>Delayed</span>
                                            @else
                                            @switch($project->status)
                                                @case('backlog')
                                                <span>Backlog</span>
                                                @break

                                                @case('in_progress')
                                                <span>In Progress</span>
                                                @break

                                                @case('completed')
                                                <span>Completed</span>
                                                @break

                                                @default
                                                <span>Unknown Status</span>
                                            @endswitch
                                                @endif
                                        </div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div v-if="editing">
                                        <div class="d-flex justify-content-start">
                                            <div class="p-2">
                                                <button class="btn btn-primary" @click="update">Update</button>
                                            </div>

                                            <div class="p-2">
                                                <button class="btn btn-outline-primary" @click="editing = false">Cancel</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </project>
                </div>

                <div class="col-md-4">
                    <div class="card mb-3">
                        <div class="card-header d-flex flex-column">
                            <form action="{{ $project->path().'/chart/' }}">
                                <input class="btn btn-outline-primary" type="submit" value="Chart View">
                            </form>

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
