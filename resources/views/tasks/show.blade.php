@extends('layouts.app')

@section('content')
    @if(auth()->check())
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-2">
                    <div class="card">
                        <div class="card-header">
                            <div class="h2">Task Name: {{ $task->name }}</div>
                        </div>

                        <div class="card-body">
                            {{ $task->description }}
                        </div>

                        <div class="card-body">
                            <hr>
                            <div class="dropdown">

                                <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    Task Status
                                </button>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">Backlog</a>
                                    <a class="dropdown-item" href="#">In Progress</a>
                                    <a class="dropdown-item" href="#">Completed</a>
                                </div>

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
                    </div>
                </div>
            </div>

            @if($task->commentCount() > 0)
                <div class="row">
                    <div class="col-md-10 col-md-offset-2">
                        <br>
                        <div class="h3">Comments</div>
                        @foreach($task->comments as $comment)

                            <div class="card">
                                <div class="card-header">
                                    {{ $comment->owner->name }} said {{ $comment->created_at->diffForHumans() }}...
                                </div>

                                <div class="card-body">
                                    {{ $comment->body }}
                                </div>

                            </div>
                            <br>
                        @endforeach
                    </div>
                </div>
            @endif

            <div class="row">
                <div class="col-md-10 col-md-offset-2">
                    <form method="POST" action="{{ $task->path().'/comments' }}">
                        {{ csrf_field() }}
                        <br>
                        <div class="form-group">
                                <textarea name="body" id="body" class="form-control"
                                          placeholder="Enter task feedback here" rows="5"></textarea>
                        </div>

                        <button type="submit" class="btn btn-outline-primary">Submit</button>
                    </form>
                </div>
            </div>
        </div>
    @else
        @include('auth.login')
    @endif
@endsection