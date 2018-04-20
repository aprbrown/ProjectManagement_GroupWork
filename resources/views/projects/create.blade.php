@extends('layouts.app')

@section('content')
    @if(auth()->check())
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-2">
                    <div class="card">
                        <div class="card-header">Create a New Project</div>
                        <div class="card-body">
                            <form method="POST" action="/projects">
                                {{ csrf_field() }}

                                <div class="form-group">
                                    <input name="name" type="text" class="form-control" id="name"
                                           value="{{ old('name') }}" placeholder="Project Name" required>
                                </div>

                                <div class="form-group">
                                    <textarea name="description" type="text" class="form-control" id="description"
                                              value="{{ old('description') }}" placeholder="Project Description" rows="8" required></textarea>
                                </div>

                                <div class="form-group">
                                    <span>
                                    <label for="start_date">Start Date:</label>
                                    <input name="start_date" id="start_date" type="date"
                                           value="{{ old('start_date') }}" placeholder="yyyy-mm-dd" required>
                                    </span>

                                    <span>
                                    <label for="due_date">Due Date:</label>
                                    <input name="due_date" id="due_date" type="date"
                                           value="{{ old('due_date') }}" placeholder="yyyy-mm-dd" required>
                                    </span>
                                </div>

                                <div class="form-group">
                                    <span>
                                    <select id="status" name="status" required>
                                        <option value="">Status...</option>
                                        <option value="backlog">Backlog</option>
                                        <option value="in_progress">In Progress</option>
                                        <option value="completed">Completed</option>
                                    </select>
                                    </span>
                                </div>

                                <span>
                                    <button type="submit" class="btn btn-primary">Create Project</button>
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

