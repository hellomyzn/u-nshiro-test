<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

use App\Models\Post;
use App\Models\User;

class PostListControllerTest extends TestCase
{
    use RefreshDatabase;
        
    /**
     * index
     *
     * @return void
     * @test
     */
    public function index_page()
    {
        $response = $this->get('/post-lists');
        $response->assertStatus(200);
    }
    
    /**
     * post
     *
     * @return void
     * @test
     */
    public function post_article()
    {
        $post1 = Post::factory()->hasComments(3)->create();
        $post2 = Post::factory()->hasComments(5)->create();
        Post::factory()->hasComments(1)->create();
        $response = $this->get('/post-lists');

        $response->assertStatus(200)
            ->assertSee($post1->title)
            ->assertSee($post2->title)
            ->assertSee($post1->user->name)
            ->assertSee('3 comments')
            ->assertSee('5 comments')
            ->assertSeeInOrder([
                '5 comments',
                '3 comments',
                '1 comments',
            ]);
        
    }
    
    /**
     * show_only_opened_posts
     *
     * @return void
     * @test
     */
    public function show_only_opened_posts()
    {
        $post_closed = Post::factory()->closed()->create([
            'title' => 'This is closed',
        ]);
        $post_opened = Post::factory()->create([
            'title' => 'This is opened',
        ]);
        
        $response = $this->get('/post-lists');
        
        $response->assertStatus(200)
            ->assertDontSee('This is closed')
            ->assertSee('This is opened');
    }
}
