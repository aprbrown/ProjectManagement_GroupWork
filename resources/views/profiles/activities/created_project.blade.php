@component('profiles.activities.activity')
    @slot ('heading')
        {{ $profileUser->name }} created a project "<a href="{{ $activity->subject->path() }}">{{ $activity->subject->name }}</a>"
        {{$activity->created_at->diffForHumans()}}...
    @endslot

    @slot ('body')
        {{ $activity->subject->description }}
    @endslot
@endcomponent