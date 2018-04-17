<div class="row">
    <div class="col-md-10 col-md-offset-2">
        <div class="collapse multi-collapse" id="{{ $collapseCall }}">
            <div class="h3">{{ $statusTitle }} Tasks</div>
            @if($project->statusCount($statusType) > 0)
                @foreach($project->$methodCall as $task)
                    <div class="card">
                        <div class="card-header">
                            <div class="h5"><a href="/tasks/{{ $task->id }}"> {{ $task->name }}</a></div>
                            <div class="p-0">Task Creator: {{ $task->taskCreator->name }}</div>
                        </div>

                        <div class="card-body">
                            {{ $task->description }}
                        </div>

                        <div class="card-footer">
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
                @endforeach

            @else
                <div class="alert">{{ $emptyListAlert }}</div>
            @endif
        </div>
    </div>
</div>