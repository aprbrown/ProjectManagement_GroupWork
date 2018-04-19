<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentOnTasksTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function unauthenticated_users_may_not_add_comments()
    {
        $this->withExceptionHandling()
            ->post('projects/some-project/tasks/1/comments', [])
            ->assertRedirect('/login');

    }

    /** @test */
    function an_authenticated_user_may_comment_on_a_task()
    {
        $this->signIn();

        $task = create('App\Task');
        $comment = make('App\Comment');

        $this->post($task->path().'/comments', $comment->toArray());

        $this->get($task->path())
            ->assertSee($comment->comment);
    }

    /** @test */
    function a_comment_requires_a_body()
    {
        $this->withExceptionHandling()->signIn();

        $task = create('App\Task');
        $comment = make('App\Comment', ['comment' => null]);

        $this->post($task->path().'/comments', $comment->toArray())
            ->assertSessionHasErrors('comment');
    }

}
