@extends('layouts.app')

@section('content')
    @if (auth()->check())
        <div class="container">
            <div class="row">
                <div class="col-md-12">
                    <div class="card mb-5">
                        <div class="card-header">
                            <div class="h2 text-center">All Projects</div>
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
                                    {{ $projectsInBacklog->count() }}
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="collapse" id="backlog">
                        @foreach($projectsInBacklog as $project)
                            <div class="card mb-3">
                                <div class="card-header">
                                    <a href="{{ $project->path() }}">
                                        {{ $project->name }}
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
                                    {{ $projectsInProgress->count() }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="collapse" id="in_progress">
                        @foreach($projectsInProgress as $project)
                            <div class="card mb-3">
                                <div class="card-header">
                                    <a href="{{ $project->path() }}">
                                        {{ $project->name }}
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
                                    {{ $projectsCompleted->count() }}
                                </button>
                            </div>
                        </div>
                    </div>

                    <div class="collapse" id="completed">
                        @foreach($projectsCompleted as $project)
                            <div class="card mb-3">
                                <div class="card-header">
                                    <a href="{{ $project->path() }}">
                                        {{ $project->name }}
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
