@extends('layouts.app')

@section('pageSpecificScript')
    <script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
    <script type="text/javascript">
        google.charts.load('current', {'packages':['gantt']});
        google.charts.setOnLoadCallback(drawChart);

        function daysToMilliseconds(days) {
            return days * 24 * 60 * 60 * 1000;
        }

        function drawChart() {
            var projectTasks = {!! json_encode($tasks->toArray()) !!};
            var data = new google.visualization.DataTable();
            data.addColumn('string', 'Task ID');
            data.addColumn('string', 'Task Name');
            data.addColumn('string', 'Resource');
            data.addColumn('date', 'Start Date');
            data.addColumn('date', 'End Date');
            data.addColumn('number', 'Duration');
            data.addColumn('number', 'Percent Complete');
            data.addColumn('string', 'Dependencies');

            projectTasks.forEach(function (task) {
                data.addRow([
                    task.name,
                    task.name,
                    task.creator.name,
                    new Date(task.start_date.substring(0, 4),
                        task.start_date.substring(5, 7)-1,
                        task.start_date.substring(8, 10)),
                    new Date(task.due_date.substring(0, 4),
                        task.due_date.substring(5, 7)-1,
                        task.due_date.substring(8, 10)),
                    null,
                    0,
                    null
                ]);

                console.log(task);
            });

            var trackHeight = 30;
            var options = {
                height: data.getNumberOfRows() * trackHeight + 40,
                gantt: {
                    trackHeight: 30,
                    percentEnabled: false,
                }
            };

            var chart = new google.visualization.Gantt(document.getElementById('chart_div'));

            chart.draw(data, options);
        }
    </script>
@stop

@section('content')


    <div class="container">
        <div class="row">
            <div class="col-md-8">
                <div class="card mb-5">
                    <div class="card-header d-flex">
                        <div class="h2 mr-auto">{{ $project->name }} </div>

                    </div>

                    <div class="card-body">
                        <div>
                            {{ $project->description }}
                        </div>
                    </div>

                    <div class="card-footer d-flex">
                            <span class="dropdown mr-auto p-2">
                                <button class="btn btn-outline-primary dropdown-toggle" type="button" id="dropdownMenuButton"
                                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    @switch($project->status)
                                        @case('backlog')
                                        Backlog
                                        @break

                                        @case('in_progress')
                                        In Progress
                                        @break

                                        @case('completed')
                                        Completed
                                        @break

                                        @default
                                        <span>Unknown Status</span>
                                    @endswitch
                                </button>

                                <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                                    <a class="dropdown-item" href="#">Backlog</a>
                                    <a class="dropdown-item" href="#">In Progress</a>
                                    <a class="dropdown-item" href="#">Completed</a>
                                </div>
                            </span>
                    </div>

                </div>
            </div>

            <div class="col-md-4">
                <div class="card mb-3">
                    <div class="card-header d-flex flex-column">
                        <form action="{{ $project->path() }}">
                            <input class="btn btn-outline-primary" type="submit" value="Task View">
                        </form>
                        <span class="p-2">Manager: <a href="/profiles/{{ $project->creator->name }}">{{ $project->creator->name }}</a></span>
                        <span class="p-2">Status:
                            @switch($project->status)
                                @case('backlog')
                                Backlog
                                @break

                                @case('in_progress')
                                In Progress
                                @break

                                @case('completed')
                                Completed
                                @break

                                @default
                                <span>Unknown Status</span>
                            @endswitch
                            </span>
                        <span class="p-2">
                                    Start Date: {{ $project->start_date->toFormattedDateString() }}
                            ({{ $project->start_date->diffForHumans() }})
                                </span>
                        <span class="p-2">
                                    Due Date: {{ $project->due_date->toFormattedDateString() }}
                            ({{ $project->due_date->diffForHumans() }})
                                </span>
                    </div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col col-md-12">
                <div id="chart_div"></div>
            </div>
        </div>
    </div>

@endsection