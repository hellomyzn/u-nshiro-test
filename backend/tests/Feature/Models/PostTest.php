<?php

namespace Tests\Feature\Models;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Post;
use App\Models\User;

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
        $post = Post::factory()->create();
        
        $this->assertInstanceOf(User::class, $post->user);
    }
}
