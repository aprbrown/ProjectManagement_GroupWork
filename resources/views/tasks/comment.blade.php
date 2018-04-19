<div class="card mb-3">
    <div class="card-header">
        <a href="#">
            {{ $comment->owner->name }}
        </a> said {{ $comment->created_at->diffForHumans() }} . . .
    </div>

    <div class="card-body">
        {{ $comment->comment }}
    </div>
</div>