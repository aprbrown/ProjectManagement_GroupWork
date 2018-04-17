@extends('layouts.app')

@section('content')
    @if(auth()->check())
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-2">
                    <div class="card">
                        <div class="card-header">
                            <div class="h2">Project Name: {{ $project->name }}</div>
                            <div class="p-0">
                                Project Manager: {{ $project->projectManager->name }}
                            </div>
                        </div>

                        <div class="card-body">
                            {{ $project->project_description }}
                        </div>

                        <div class="card-body">
                            <hr>
                            <div class="dropdown">

                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Project Status
                                </button>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">Backlog</a>
                                    <a class="dropdown-item" href="#">In Progress</a>
                                    <a class="dropdown-item" href="#">Completed</a>
                                </div>

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
                            </div>
                        </div>

                        <div class="card-footer">
                            <div class="">
                                <a class="btn btn-primary" data-toggle="collapse" href="#backlogCollapse" role="button"
                                   aria-expanded="false" aria-controls="backlogCollapse">
                                    Backlog <span class="badge badge-light">{{ $project->statusCount('backlog') }}</span>
                                </a>

                                <a class="btn btn-primary" data-toggle="collapse" href="#inProgressCollapse" role="button"
                                   aria-expanded="false" aria-controls="inProgressCollapse">
                                    In Progress <span class="badge badge-light">{{ $project->statusCount('in_progress') }}</span>
                                </a>

                                <a class="btn btn-primary" data-toggle="collapse" href="#completedCollapse" role="button"
                                   aria-expanded="false" aria-controls="completedCollapse">
                                    Completed <span class="badge badge-light">{{ $project->statusCount('completed') }}</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            @include('projects._taskgroups', [
                'collapseCall' => 'backlogCollapse',
                'statusTitle'=>'Backlog',
                'statusType'=>'backlog',
                'methodCall'=>'tasksInBacklog',
                'emptyListAlert'=>'There are no tasks in the backlog'
            ])

            @include('projects._taskgroups', [
                'collapseCall' => 'inProgressCollapse',
                'statusTitle'=>'In Progress',
                'statusType'=>'in_progress',
                'methodCall'=>'tasksInProgress',
                'emptyListAlert'=>'There are no tasks in progress'
            ])

            @include('projects._taskgroups', [
                'collapseCall' => 'completedCollapse',
                'statusTitle'=>'Completed',
                'statusType'=>'completed',
                'methodCall'=>'tasksCompleted',
                'emptyListAlert'=>'There are no completed tasks'
            ])

        </div>
    @else
        @include('auth.login')
    @endif
@endsection
