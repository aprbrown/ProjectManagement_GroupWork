<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProjectTest extends TestCase
{
    Use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();

        $this->project = create('App\Project');
    }

    /** @test */
    public function a_project_consists_of_tasks()
    {
        $project = create('App\Project');
        $task = create('App\Task', ['project_id' => $project->id]);

        $this->assertTrue($project->tasks->contains($task));
    }

//    Joe
    /**@test */
    public function testTaskCount()
    {
        $project = create('App\Project');
        $task = create('App\Task', ['project_id' => $project->id]);
        $task2 = create('App\Task', ['project_id' => $project->id]);
        $task3 = create('App\Task', ['project_id' => $project->id]);

        $this->assertEquals(3, $project->taskCount());
    }

//    Joe
    /**@test */
    public function testPath()
    {
        $this->assertEquals("/projects/{$this->project->slug}", $this->project->path());
    }

//    Joe
    /**@test*/
    public function testCreator()
    {
        $this->assertInstanceOf('App\User', $this->project->creator);
    }

//    Joe
    /**@test*/
    public function testDates()
    {
        $this->assertEquals($this->project->start_date, $this->project->getStartDate());
        $this->assertEquals($this->project->due_date, $this->project->getDueDate());

    }
}
