@extends('layouts.app')

@section('content')
    @if(auth()->check())
        <div class="container">
            <div class="row">
                <div class="col-md-10 col-md-offset-2">
                    <div class="card">
                        <div class="card-header">Tasks</div>
                        <div class="card-body">
                            @foreach($tasks as $task)
                                <article>
                                    <div class="h4">
                                        <a href="{{ $task->path() }}">
                                            {{ $task->name }}
                                        </a>
                                    </div>

                                    <div class="body">
                                        {{ $task->description }}
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

