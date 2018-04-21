<?php
namespace Tests\Feature;

use App\Activity;
use Carbon\Carbon;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ActivityTest extends TestCase
{
    Use DatabaseMigrations;

    /** @test */
    public function it_records_activity_when_a_task_is_created()
    {
        $this->signIn();
        $task = create('App\Task');

        $this->assertDatabaseHas('activities', [
            'type' => 'created_task',
            'user_id' => auth()->id(),
            'subject_id' => $task->id,
            'subject_type' => 'App\Task'
        ]);

        $activity = Activity::first();

        $this->assertEquals($activity->subject->id, $task->id);
    }

    /** @test */
    public function it_records_activity_when_a_comment_is_made()
    {
        $this->signIn();
        create('App\Comment');

        $this->assertEquals(3, Activity::count());
    }

    /** @test */
    public function it_fetches_an_activity_feed_for_any_user()
    {
        $this->signIn();

        create('App\Task', ['user_id' => auth()->id()], 2);

        auth()->user()->activity()->first()->update(['created_at' => Carbon::now()->subWeek()]);

        $feed = Activity::feed(auth()->user(), 20);

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->format('Y-m-d')
        ));

        $this->assertTrue($feed->keys()->contains(
            Carbon::now()->subWeek()->format('Y-m-d')
        ));


    }
}
