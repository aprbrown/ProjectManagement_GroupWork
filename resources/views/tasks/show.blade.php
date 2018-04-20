@extends('layouts.app')

@section('content')
    @if (auth()->check())
        <div class="container">
            <div class="row">
                <div class="col col-md-8">
                    <div class="card mb-3">
                        <div class="card-header">
                            <div class="h3">
                                {{ $task->name }}
                            </div>

                            <div class="blockquote-footer">
                                Created By: <a href="#">{{ $task->creator->name }}</a>
                            </div>
                        </div>

                        <div class="card-body">
                            {{ $task->description }}
                        </div>

                        <div class="card-footer d-flex justify-content-between">
                            <span>Start Date: {{ $task->start_date }}</span>
                            <span>Due Date: {{ $task->due_date }}</span>
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



                    @foreach($task->comments as $comment)

                        @include('tasks.comment')

                    @endforeach

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
                    <div class="card">
                        <div class="card-header d-flex flex-column">
                            <span class="p-2">Project: <a href="{{ $task->project->path() }}">{{ $task->project->name }}</a></span>
                            <span class="p-2">Manager: <a href="#">{{ $task->project->creator->name }}</a></span>
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
                            <span class="p-2">Start Date: {{ $task->project->start_date }}</span>
                            <span class="p-2">Due Date: {{ $task->project->due_date }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        @include('auth.login')
    @endif
@endsection
