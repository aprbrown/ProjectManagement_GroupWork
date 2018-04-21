<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CreateTasksTest extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    function an_unauthenticated_user_cannot_create_a_task()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $task = make('App\Task');
        $this->post('/tasks', $task->toArray());
    }

    /** @test */
    function someone_who_is_not_signed_in_cannot_see_create_form()
    {
        $this->withExceptionHandling()
            ->get('/tasks/create')
            ->assertRedirect('/login');
    }

    /** @test */
    function an_authenticated_user_can_create_a_new_task()
    {
        $this->signIn();

        $project = create('App\Project');
        $task = make('App\Task', ['project_id' => $project->id]);

//        dd($task->toArray());

        $response = $this->post('/tasks', $task->toArray());

        $this->get($response->headers->get('Location'))
            ->assertSee($task->name)
            ->assertSee($task->description);
    }

    /** @test */
    function a_task_requires_a_name()
    {
        $this->createTask(['name' => null])
            ->assertSessionHasErrors('name');
    }

    /** @test */
    function a_task_requires_a_description()
    {
        $this->createTask(['description' => null])
            ->assertSessionHasErrors('description');
    }

    /** @test */
    function a_task_requires_a_status()
    {
        $this->createTask(['status' => null])
            ->assertSessionHasErrors('status');
    }

    /** @test */
    function a_task_requires_a_priority()
    {
        $this->createTask(['priority' => null])
            ->assertSessionHasErrors('priority');
    }/** @test */
    function a_task_requires_a_start_date()
    {
        $this->createTask(['start_date' => null])
            ->assertSessionHasErrors('start_date');
    }

    /** @test */
    function a_task_requires_a_due_date()
    {
        $this->createTask(['due_date' => null])
            ->assertSessionHasErrors('due_date');
    }

    /** @test */
    function a_task_requires_an_existing_project()
    {
        factory('App\Project', 2)->create();

        $this->createTask(['project_id' => null])
            ->assertSessionHasErrors('project_id');

        $this->createTask(['project_id' => 9999])
            ->assertSessionHasErrors('project_id');
    }

    /** @test */
    function a_task_can_be_deleted_by_task_creator()
    {
        $this->signIn();
        $task = create('App\Task', ['user_id' => auth()->id()]);
        $comment = create('App\Comment', ['task_id' => $task->id]);

        $response = $this->json('DELETE', $task->path());

        $response->assertStatus(204);

        $this->assertDatabaseMissing('tasks', ['id' => $task->id]);
        $this->assertDatabaseMissing('comments', ['id' => $comment->id]);

        $this->assertDatabaseMissing('activities', [
            'subject_id' => $task->id,
            'subject_type' => get_class($task)
        ]);

        $this->assertDatabaseMissing('activities', [
            'subject_id' => $comment->id,
            'subject_type' => get_class($comment)
        ]);
    }

//    /** @test */
//    function tasks_may_only_be_deleted_by_those_with_permission()
//    {
//
//    }

    function createTask($overrides = [])
    {
        $this->withExceptionHandling()->signIn();
        $task = make('App\Task', $overrides);
        return $this->post('/tasks', $task->toArray());
    }
}
