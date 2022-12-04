<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Post;

class PostListControllerTest extends TestCase
{
    use RefreshDatabase;
        
    /**
     * index
     *
     * @return void
     * @test
     */
    public function index_page(){
        $response = $this->get('/post-lists');
        $response->assertStatus(200);
    }
    
    /**
     * post
     *
     * @return void
     * @test
     */
    public function post_article(){
        $post1 = Post::factory()->create();
        $post2 = Post::factory()->create();
        $response = $this->get('/post-lists');

        $response->assertStatus(200)
            ->assertSee($post1->title)
            ->assertSee($post2->title)
            ->assertSee($post1->user->name);
        
    }
}
