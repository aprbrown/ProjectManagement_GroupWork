<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class TaskTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->task = create('App\Task');

    }

    /** @test */
    function a_task_has_comments()
    {
        $this->assertInstanceOf('Illuminate\Database\Eloquent\Collection', $this->task->comments);
    }

    /** @test */
    function a_task_has_a_creator()
    {
        $this->assertInstanceOf('App\User', $this->task->creator);
    }

    /** @test */
    function a_task_can_add_a_reply()
    {
        $this->task->addComment([
           'comment' => 'Foobar',
           'user_id' =>  1
        ]);

        $this->assertCount(1, $this->task->comments);
    }

    /** @test */
    function a_task_belongs_to_a_project()
    {
        $task = create('App\Task');

        $this->assertInstanceOf('App\Project', $task->project);
    }

    /** @test */
    function a_task_can_make_a_string_path()
    {
        $task = create('App\Task');

        $this->assertEquals("/projects/{$task->project->slug}/tasks/{$task->id}", $task->path());
    }

}
