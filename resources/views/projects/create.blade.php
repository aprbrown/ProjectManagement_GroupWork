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
                                    <input name="name" type="text" class="form-control" id="name" placeholder="Project Name" required>
                                </div>

                                <div class="form-group">
                                    <textarea name="project_description" type="text" class="form-control" id="project_description" placeholder="Project Description" required></textarea>
                                </div>

                                <div class="form-group">
                                    <label for="start_date">Start Date:</label>
                                    <input name="start_date" id="start_date" type="date" placeholder="yyyy-mm-dd" required>
                                </div>

                                <div class="form-group">
                                    <label for="due_date">Due Date:</label>
                                    <input name="due_date" id="due_date" type="date" placeholder="yyyy-mm-dd" required>
                                </div>

                                <div class="form-group">
                                    <label for="status">Status:</label>
                                    <select id="status" name="status" required>
                                        <option value="backlog">Backlog</option>
                                        <option value="in_progress">In Progress</option>
                                        <option value="completed">Completed</option>
                                    </select>
                                </div>

                                <button type="submit" class="btn btn-primary">Create Project</button>
                            </form>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        @include('auth.login')
    @endif
@endsection

