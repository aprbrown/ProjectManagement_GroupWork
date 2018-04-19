@extends('layouts.app')

@section('content')
    @if (auth()->check())
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-5">
                    <div class="card-header">
                        <div class="h2 text-center">All Tasks</div>
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
                                {{ $tasksInBacklog->count() }}
                            </button>
                        </div>
                    </div>
                </div>
                <div class="collapse" id="backlog">
                @foreach($tasksInBacklog as $task)
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
                                {{ $tasksInProgress->count() }}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="collapse" id="in_progress">
                @foreach($tasksInProgress as $task)
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
                                {{ $tasksCompleted->count() }}
                            </button>
                        </div>
                    </div>
                </div>

                <div class="collapse" id="completed">
                @foreach($tasksCompleted as $task)
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
