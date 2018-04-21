@component('profiles.activities.activity')
    @slot ('heading')
        {{ $profileUser->name }} created a task "<a href="{{ $activity->subject->path() }}">{{ $activity->subject->name }}</a>"
        {{$activity->created_at->diffForHumans()}}...
    @endslot

    @slot ('body')
        {{ $activity->subject->description }}
    @endslot
@endcomponent