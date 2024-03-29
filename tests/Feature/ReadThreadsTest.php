<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

class ReadThreadsTest extends TestCase
{

    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->thread = factory('App\Thread')->create();
    }

    /** @test */
    public function a_user_can_browse_threads()
    {
        $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_read_a_single_thread()
    {
        $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }

    public function a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        // Given that we have a thread and that thread includes replies
        $reply = factory('App\Reply')
            ->create(['thread_id' => $this->thread-id]);

        // When we visit a thread page we should see the replies
        $this->get($this->thread->path())
            ->assertSee($reply->body);
    }
}
