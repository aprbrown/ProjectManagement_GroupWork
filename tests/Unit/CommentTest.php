<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CommentTest extends TestCase
{
    use DatabaseMigrations;
    /** @test */
    public function it_has_an_owner()
    {
        $comment = create('App\Comment');

        $this->assertInstanceOf('App\User', $comment->owner);
    }
}
