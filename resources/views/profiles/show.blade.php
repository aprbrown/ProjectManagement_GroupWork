@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card mb-3">
            <div class="card-header">
                <h1 class="card-title">{{ $profileUser->name }}</h1>
            </div>
        </div>

        <div class="row">
            <div class="col col-md-8">
                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="h3">Tasks in Backlog</h3>
                    </div>
                </div>
                @foreach($backlogTasks as $task)
                    <div class="card mb-3">
                        <div class="card-header">
                            <a href="{{ $task->path() }}">
                                {{ $task->name }}
                            </a>
                        </div>

                        <div class="card-body">
                            {{ $task->description }}
                        </div>
                    </div>
                @endforeach
                {{ $backlogTasks->links() }}

                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="h3">In Progress Tasks</h3>
                    </div>
                </div>
                @foreach($inProgressTasks as $task)
                    <div class="card mb-3">
                        <div class="card-header">
                            <a href="{{ $task->path() }}">
                                {{ $task->name }}
                            </a>
                        </div>

                        <div class="card-body">
                            {{ $task->description }}
                        </div>
                    </div>
                @endforeach
                {{ $inProgressTasks->links() }}

                <div class="card mb-3">
                    <div class="card-header">
                        <h3 class="h3">Completed Tasks</h3>
                    </div>
                </div>
                @foreach($completedTasks as $task)
                    <div class="card mb-3">
                        <div class="card-header">
                            <a href="{{ $task->path() }}">
                                {{ $task->name }}
                            </a>
                        </div>

                        <div class="card-body">
                            {{ $task->description }}
                        </div>
                    </div>
                @endforeach
                {{ $completedTasks->links() }}
            </div>
            <div class="col col-md-4">
                <div class="card mb-3">
                    <div class="card-header">
                        <span class="h4">User Stats</span>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-column">
                            <span>Tasks In Backlog: {{ $profileUser->backlogCount() }}</span>
                            <span>Tasks In Progress: {{ $profileUser->inProgressCount() }}</span>
                            <span>Tasks Completed: {{ $profileUser->completedCount() }}</span>
                        </div>
                    </div>
                </div>

                <div class="card mb-1">
                    <div class="card-header">
                        <span class="h4">User Activity</span>
                    </div>
                </div>
                @foreach($allActivities as $date => $activities)
                    <div class="card mb-1">
                        <div class="card-header">
                            <span class="h5">{{ $date }}</span>
                        </div>
                    </div>
                    @foreach($activities as $activity)
                        @if(view()->exists("profiles.activities.{$record->type}"))
                            @include ("profiles.activities.{$activity->type}")
                        @endif
                    @endforeach
                @endforeach
            </div>
        </div>
    </div>
@endsection