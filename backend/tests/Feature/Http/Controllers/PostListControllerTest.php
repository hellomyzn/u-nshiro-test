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
        $user = User::factory()->create();
        $post1 = Post::factory()->hasComments(3)->create(['user_id' => $user->id]);
        $post2 = Post::factory()->hasComments(5)->create(['user_id' => $user->id]);
        Post::factory()->hasComments(1)->create(['user_id' => $user->id]);
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
}
