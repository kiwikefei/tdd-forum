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
        $thread = make('App\Thread');
        $this->post('/threads', $thread->toArray());
    }
    /** @test */
    public function guests_can_not_see_create_thread_page()
    {
        $this->withExceptionHandling()
            ->get('/threads/create')
            ->assertRedirect('/login');
    }
    /** @test */
    public function an_authenticated_user_can_create_threads()
    {
        // Given we have a signed in user,
        $this->signIn();
        // When we hit the endpoint to create a thread,
        $thread = make('App\Thread');

        $this->post('/threads', $thread->toArray());
        // Then, when we visit the thread page,
        $respond = $this->get($thread->path());
        // We should see the new thread.
        $respond->assertSee($thread->title)
            ->assertSee($thread->body);
    }
}
