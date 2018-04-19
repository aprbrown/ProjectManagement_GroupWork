<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ViewTasksTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->task = create('App\Task');
        $this->signIn();
    }

    /** @test */
    public function a_user_can_view_all_tasks()
    {
        $this->get('/tasks')
            ->assertSee($this->task->name);
    }

    /** @test */
    public function a_user_can_view_a_single_task()
    {
        $this->get($this->task->path())
            ->assertSee($this->task->name);
    }

    /** @test */
    public function a_user_can_read_comments_for_a_task()
    {
        $comment = create('App\Comment', ['task_id' => $this->task->id]);

        $this->get($this->task->path())
            ->assertSee($comment->comment);
    }

    /** @test */
    function a_user_can_see_all_tasks_associated_with_a_project()
    {
        $project = create('App\Project');
        $taskInProject = create('App\Task', ['project_id' => $project->id]);
        $taskNotInProject = create('App\Task');

        $this->get('/projects/'.$project->slug)
            ->assertSee($taskInProject->title)
            ->assertDontSee($taskNotInProject);
    }

}
