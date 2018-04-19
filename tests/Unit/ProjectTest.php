<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProjectTest extends TestCase
{
    Use DatabaseMigrations;

    /** @test */
    public function a_project_consists_of_tasks()
    {
        $project = create('App\Project');
        $task = create('App\Task', ['project_id' => $project->id]);

        $this->assertTrue($project->tasks->contains($task));
    }
}
