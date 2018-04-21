@component('profiles.activities.activity')
    @slot ('heading')
        {{ $profileUser->name }} commented on
        "<a href="{{ $activity->subject->task->path() }}" >{{ $activity->subject->task->name }}</a>"
            {{$activity->created_at->diffForHumans()}}...
    @endslot

    @slot ('body')
        {{ $activity->subject->comment }}
    @endslot
@endcomponent