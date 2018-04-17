@extends('layouts.app')

@section('content')
    @if(auth()->check())
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-2">
                    <div class="card">
                        <div class="card-header">Projects</div>
                        <div class="card-body">
                            @foreach($projects as $project)
                                <article>
                                    <div class="h4">
                                        <a href="{{ $project->path() }}">
                                            {{ $project->name }}
                                        </a>
                                    </div>

                                    <div class="body">
                                        {{ $project->project_description }}
                                    </div>

                                </article>

                                <hr>

                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @else
        @include('auth.login')
    @endif
@endsection

