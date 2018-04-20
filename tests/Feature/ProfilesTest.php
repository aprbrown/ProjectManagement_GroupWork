<?php
namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ProfilesTest extends TestCase
{
    Use DatabaseMigrations;
    
    /** @test */
    public function a_user_has_a_profile()
    {
        $user = create('App\User');

        $this->get("/profiles/{$user->name}")
            ->assertSee($user->name);
    }

    /** @test */
    public function profile_displays_tasks_associated_with_user()
    {
        $user = create('App\User');
        $task = create('App\Task', ['user_id' => $user->id]);

        $this->get("/profiles/{$user->name}")
            ->assertSee($task->name)
            ->assertSee($task->description);
    }
}
