<nav class="navbar navbar-expand-md navbar-light navbar-laravel">
    <div class="container">
        <a class="navbar-brand" href="{{ url('/') }}">
            Team 15 Project App
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <!-- Left Side Of Navbar -->
            @guest

            @else
                <ul class="navbar-nav mr-auto">
                    @if(auth()->user()->hasRole("admin") || auth()->user()->hasRole("project_manager"))
                    <li class="nav-item nav-link">
                        <a href="/projects/create">New Project</a>
                    </li>

                    <li class="nav-item nav-link">
                        <a href="/tasks/create">New Task</a>
                    </li>
                    @endif

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="projectsDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Projects
                        </a>
                        <div class="dropdown-menu" aria-labelledby="projectsDropdown">
                            @foreach($projects as $project)
                                <a class="dropdown-item" href="/projects/{{ $project->slug }}">
                                    {{ $project->name }}
                                </a>
                            @endforeach
                        </div>
                    </li>

                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" id="viewDropdown" role="button"
                           data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            View
                        </a>
                        <div class="dropdown-menu" aria-labelledby="viewDropdown">
                            <a class="dropdown-item" href="/projects">All Projects</a>
                            <a class="dropdown-item" href="/tasks">All Tasks</a>
                        </div>
                    </li>
                </ul>
        @endguest

        <!-- Right Side Of Navbar -->
            <ul class="navbar-nav ml-auto">
                <!-- Authentication Links -->
                @guest
                    <li><a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a></li>
                    <li><a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a></li>
                @else
                    <li class="nav-item dropdown">
                        <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            {{ Auth::user()->name }} <span class="caret"></span>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="navbarDropdown">
                            @if(auth()->user()->hasRole("admin"))
                                <a class="dropdown-item" href="/admin">Admin</a>
                            @endif
                            <a class="dropdown-item" href="{{ '/profiles/'.Auth::user()->name }}">My Profile</a>
                            <a class="dropdown-item" href="{{ route('logout') }}"
                               onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                {{ __('Logout') }}
                            </a>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                @csrf
                            </form>
                        </div>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>