<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ReadProjectsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->project = factory('App\Project')->create();

    }

    /** @test */
    public function a_user_can_browse_projects()
    {

        $this->get('/projects')->assertSee($this->project->name);
    }

    /** @test */
    public function a_user_can_see_a_single_project()
    {

        $this->get('/projects/' . $this->project->id)->assertSee($this->project->name);
    }

    /** @test */
    public function a_user_can_see_all_tasks_associated_with_a_project()
    {
        $task = factory('App\Task')->create(['project_id' => $this->project->id]);

        $this->get('/projects/' . $this->project->id)->assertSee($task->description);
    }
}
