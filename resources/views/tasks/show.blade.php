@extends('layouts.app')

@section('content')
    @if (auth()->check())
        <div class="container">
            <div class="row">
                <div class="col col-md-8">
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="d-flex">
                                <div class="h3 flex-grow-1">
                                    {{ $task->name }}
                                </div>

                                <div class="justify-content-end">
                                    @can('update', $task)
                                        <form action="{{ $task->path() }}" method="POST">
                                            {{ csrf_field() }}
                                            {{ method_field('DELETE') }}

                                            <button class="btn btn-danger" type="submit">Delete Task</button>
                                        </form>
                                    @endcan
                                </div>
                            </div>

                            <div class="blockquote-footer">
                                Created By: <a href="/profiles/{{ $task->creator->name }}">{{ $task->creator->name }}</a>
                            </div>
                        </div>

                        <div class="card-body">
                            {{ $task->description }}
                        </div>

                        <div class="card-footer d-flex justify-content-between">
                            <span>Start Date: {{ $task->start_date->toFormattedDateString() }}</span>
                            <span>Due Date: {{ $task->due_date->toFormattedDateString() }}</span>
                            <span>
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
                            </span>

                            <span>
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
                                </span>
                        </div>
                    </div>

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
