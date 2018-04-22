<comment :attributes="{{ $comment }}" inline-template v-cloak>
    <div id="comment-{{ $comment->id }}" class="card mb-3">
        <div class="card-header d-flex">
            <div class="mr-auto">
                <a href="/profiles/{{ $comment->owner->name }}">
                    {{ $comment->owner->name }}
                </a> said {{ $comment->created_at->diffForHumans() }} . . .
            </div>

            @can ('update', $comment)
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item dropdown">
                        <a id="optionsDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                            Options <span class="oi oi-cog"></span>
                        </a>

                        <div class="dropdown-menu" aria-labelledby="optionsDropdown">
                            <a class="dropdown-item" href="#"
                               @click="editing = true">
                                Edit Comment
                            </a>

                            <a class="dropdown-item text-danger" href="#" @click="destroy">
                                Delete Comment
                            </a>
                        </div>
                    </li>
                </ul>
            @endcan
        </div>

        <div class="card-body">
            <div v-if="editing">
                <div class="form-group">
                    <textarea class="form-control" v-model="body"></textarea>
                </div>

                <button class="btn btn-primary" @click="update">Update</button>
                <button class="btn btn-outline-primary" @click="editing = false">Cancel</button>
            </div>

            <div v-else v-text="body"></div>

        </div>
    </div>
</comment>