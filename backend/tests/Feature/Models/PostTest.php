<?php

namespace Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;

class PostTest extends TestCase
{
    use RefreshDatabase;
    /**
     * hoge
     *
     * @return void
     * @test
     */
    public function respond_user_relation()
    {
        // $this->seed();
        $post = Post::factory()->create();

        $this->assertInstanceOf(User::class, $post->user);
    }

    /**
     * respond_comments_relation
     *
     * @return void
     * @test
     */
    public function respond_comments_relation()
    {
        $post = Post::factory()->hasComments(3)->create();

        $this->assertInstanceOf(Collection::class, $post->comments);
        $this->assertInstanceOf(Comment::class, $post->comments[0]);
    }

        
    /**
     * scopeOnlyOpen
     *
     * @return void
     * @test
     */
    public function scopeOnlyOpen()
    {
        $post_closed = Post::factory()->closed()->create();
        $post_opened = Post::factory()->create();

        $posts = Post::onlyOpen()->get();

        $this->assertFalse($posts->contains($post_closed));
        $this->assertTrue($posts->contains($post_opened));
    }

    /**
     * isClosed
     *
     * @return void
     * @test
     */
    public function isClosed()
    {
        $post_closed = Post::factory()->closed()->make();
        $post_opened = Post::factory()->make();

        $this->assertTrue($post_closed->isClosed());
        $this->assertFalse($post_opened->isClosed());
    }
}
