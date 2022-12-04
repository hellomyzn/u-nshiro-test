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
    public function respond_user_relation(){
        // $this->seed();
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);

        $this->assertInstanceOf(User::class, $post->user);
    }

    /**
     * respond_comments_relation
     *
     * @return void
     * @test
     */
    public function respond_comments_relation(){
        $user = User::factory()->create();
        $post = Post::factory()->create(['user_id' => $user->id]);
        Comment::factory(3)->create(['post_id' => $post->id]);

        $this->assertInstanceOf(Collection::class, $post->comments);
        $this->assertInstanceOf(Comment::class, $post->comments[0]);
    }
}
