<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\DatabaseMigrations;

/**
 * @property mixed thread
 */
class ReadThreadsTest extends TestCase
{
    use DatabaseMigrations;

    public function setUp()
    {
        parent::setUp();
        $this->thread = create('App\Thread');

    }
    /** @test */
    public function a_user_can_view_all_threads()
    {

       $this->get('/threads')
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_view_single_thread()
    {
        $this->get($this->thread->path())
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_read_replies_that_are_associated_with_a_thread()
    {
        // Given we have a thread
        $reply = create('App\Reply', [
            'thread_id' => $this->thread->id
        ]);
        //  and that thread includes replies
        // When we visit a thread
        // Then we should see the replies
        $this->get($this->thread->path())
             ->assertSee($reply->body);
    }
}
