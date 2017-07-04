<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class CreateThreadTest extends TestCase
{
    /** @test */
    use DatabaseMigrations;
    /** @test */
    public function guests_may_not_create_threads()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
        $thread = factory('App\Thread')->make();
        $this->post('/threads', $thread->toArray());
    }
    public function an_authenticated_user_can_create_threads()
    {
        // Given we have a signed in user,
        $this->actingAs(factory('App\User')->create());
        // When we hit the endpoint to create a thread,
        $thread = factory('App\Thread')->make();

        $this->post('/threads', $thread->toArray());
        // Then, when we visit the thread page,
        $respond = $this->get($thread->path());
        // We should see the new thread.
        $respond->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}