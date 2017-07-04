<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ParticipateInForum extends TestCase
{
    use DatabaseMigrations;

    /** @test */
    public function unauthenticated_users_may_not_add_replies()
    {
        $this->expectException('Illuminate\Auth\AuthenticationException');
//        $thread = factory('App\Thread')->create();
//        $reply = factory('App\Reply')->make();
//        $this->post($thread->path() . '/replies', $reply->toArray());
        $this->post('/threads/1/replies',[]);

    }
    /** @test */
    public function an_authenticated_user_may_participate_in_forum_thread()
    {
        // == Plan ==
        // Given we have an authenticated user
        $user = factory('App\User')->create();
        $this->be($user);
        // And an existing thread
        $thread = factory('App\Thread')->create();

        // When the user adds a reply to the thread
        $reply = factory('App\Reply')->make();
        // simulate them hitting the 'submit' button.
        $this->post($thread->path() . '/replies', $reply->toArray());
        // Then their reply should be visible on the pate.
        $this->get($thread->path())
            ->assertSee($reply->body);
        // == Prepare ==
        // == Action ==
    }
}
