@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="card mb-5">
                    <div class="card-header">
                        <div class="h2 text-center">Admin Home</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-wrap">
                @foreach($users as $user)
                    <div class="card m-1">
                        <div class="card-header">
                            {{ $user->name }}
                        </div>

                        <div class="card-body">
                            @foreach($user->roles as $role)
                                {{ $role->name }}
                            @endforeach
                        </div>
                    </div>
                @endforeach
        </div>





    </div>
@endsection