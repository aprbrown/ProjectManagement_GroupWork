@extends('layouts.app')

@section('content')
    @if(auth()->check())
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-2">
                    <div class="card">
                        <div class="card-header">Create a New Task</div>
                        <div class="card-body">
                            <form method="POST" action="/tasks">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <select name="project_id" id="project_id" class="form-control" required>
                                        <option value="">Choose a project...</option>
                                        @foreach(App\Project::all() as $project)
                                            <option value="{{ $project->id }}" {{ old('project_id') == $project->id ? 'selected' : '' }}>
                                                {{ $project->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group">
                                    <input name="name" type="text" class="form-control" id="name"
                                           value="{{ old('name') }}" placeholder="Task Name" required>
                                </div>

                                <div class="form-group">
                                    <textarea name="description" type="text" class="form-control" id="description"
                                              value="{{ old('description') }}" placeholder="Task Description" rows="8" required></textarea>
                                </div>

                                <div class="form-group">
                                    <span>
                                    <label for="start_date">Start Date:</label>
                                    <input name="start_date" id="start_date" type="date"
                                           value="{{ old('start_date') }}" placeholder="yyyy-mm-dd" required>
                                    </span>

                                    <span class="col-md-4 col-md-offset-2">
                                    <label for="due_date">Due Date:</label>
                                    <input name="due_date" id="due_date" type="date"
                                           value="{{ old('due_date') }}" placeholder="yyyy-mm-dd" required>
                                    </span>
                                </div>

                                <div class="form-group">
                                    <span>
                                    <select id="priority" name="priority" required>
                                        <option value="">Priority...</option>
                                        <option value="low">Low</option>
                                        <option value="normal">Normal</option>
                                        <option value="high">High</option>
                                    </select>
                                    </span>
                                <span class="col-md-4 col-md-offset-2">
                                    <select id="status" name="status" required>
                                        <option value="">Status...</option>
                                        <option value="backlog">Backlog</option>
                                        <option value="in_progress">In Progress</option>
                                        <option value="completed">Completed</option>
                                    </select>
                                    </span>
                                </div>

                                <span class="col-md-offset-1">
                                <button type="submit" class="btn btn-primary">Create Task</button>
                                </span>
                            </form>

                            @if(count($errors))
                                <ul class="alert alert-danger mt-3">
                                    @foreach($errors->all() as $error)
                                        <li>{{$error}}</li>
                                    @endforeach
                                </ul>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        @include('auth.login')
    @endif
@endsection

