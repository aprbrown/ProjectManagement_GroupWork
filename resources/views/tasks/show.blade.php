@extends('layouts.app')

@section('content')
    @if (auth()->check())
        <div class="container">
            <div class="row">
                <div class="col col-md-8">
                    <task :attributes="{{ $task }}" inline-template v-cloak>
                        <div class="card mb-3">
                            <div class="card-header">
                                <div class="d-flex">
                                    <div class="flex-grow-1">
                                        <div v-if="editing">
                                            <textarea class="form-control" v-model="title"></textarea>
                                        </div>

                                        <div class="h3" v-else v-text="title"></div>

                                        <div class="blockquote-footer">
                                            Created By: <a href="/profiles/{{ $task->creator->name }}">{{ $task->creator->name }}</a>
                                        </div>
                                    </div>

                                    <div class="justify-content-end">
                                        @can('update', $task)
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
                                                            Edit Task
                                                        </a>

                                                        <a class="dropdown-item text-danger" href="#"
                                                           onclick="event.preventDefault();
                                                        document.getElementById('deleteTask').submit()">
                                                            Delete Task
                                                        </a>
                                                    </div>
                                                </li>
                                            </ul>

                                            <form id="deleteTask" action="{{ $task->path() }}" method="POST">
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

                            <div class="card-footer">
                                <div class="row">
                                    <div class="p-2">
                                        <div v-if="editing">
                                            <label for="start_date">Current Start Date: {{ $task->start_date->toFormattedDateString() }}</label>
                                            <br>
                                            <input name="start_date" id="start_date" type="date"
                                                   value="{{ old('start_date') }}" placeholder="yyyy-mm-dd"  v-model="startDate">
                                        </div>

                                        <div v-else>
                                            Start Date: {{ $task->start_date->toFormattedDateString() }}
                                        </div>
                                    </div>

                                    <div class="p-2">
                                        <div v-if="editing">
                                            <label for="due_date">Current Due Date: {{ $task->due_date->toFormattedDateString() }}</label>
                                            <br>
                                            <input name="due_date" id="due_date" type="date" placeholder="yyyy-mm-dd"  v-model="dueDate">
                                        </div>

                                        <div v-else>
                                            Due Date: {{ $task->due_date->toFormattedDateString() }}
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
                                            @switch($task->status)
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
                                        </div>
                                    </div>

                                    <div class="p-2">
                                        <div v-if="editing">
                                            <select id="priority" name="priority" v-model="priority">
                                                <option value="">Priority...</option>
                                                <option value="low">Low</option>
                                                <option value="normal">Normal</option>
                                                <option value="high">High</option>
                                            </select>
                                        </div>

                                        <div v-else>
                                            Priority:
                                            @switch($task->priority)
                                                @case('low')
                                                <span>Low</span>
                                                @break

                                                @case('normal')
                                                <span>Normal</span>
                                                @break

                                                @case('high')
                                                <span>High</span>
                                                @break

                                                @default
                                                <span>Unknown Status</span>
                                            @endswitch
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
                    </task>

                    @foreach($comments as $comment)

                        @include('tasks.comment')

                    @endforeach

                    {{ $comments->links() }}

                    <div class="card mb-3">
                        <div class="card-body">
                            <form method="POST" action="{{ $task->path().'/comments' }}">
                                {{ csrf_field() }}
                                <div class="form-group">
                                        <textarea name="comment" id="comment" class="form-control" placeholder="Add a Comment"
                                                  rows="5" required></textarea>
                                </div>

                                <button type="submit" class="btn-primary">Post</button>
                            </form>
                        </div>
                    </div>
                </div>


                <div class="col col-md-4">
                    <div class="card mb-3">
                        <div class="card-header d-flex flex-column">
                            <span class="p-2">Project: <a href="{{ $task->project->path() }}">{{ $task->project->name }}</a></span>
                            <span class="p-2">Manager: <a href="/profiles/{{ $task->project->creator->name }}">{{ $task->project->creator->name }}</a></span>
                            <span class="p-2">Status:
                                @switch($task->project->status)
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
                                Start Date: {{ $task->project->start_date->toFormattedDateString() }}
                                ({{ $task->project->start_date->diffForHumans() }})
                            </span>

                            <span class="p-2">
                                Due Date: {{ $task->project->due_date->toFormattedDateString() }}
                                ({{ $task->project->due_date->diffForHumans() }})
                            </span>
                        </div>
                    </div>

                    <div class="card mb-3">
                        <div class="card-header d-flex flex-column">
                            <span class="p-2">
                                This task has {{ $task->comments_count }}
                                {{ str_plural('comment', $task->comments_count) }}.
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        @include('auth.login')
    @endif
@endsection
