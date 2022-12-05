<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Carbon\Carbon;

use App\Models\Post;
use App\Models\User;
use App\Models\Comment;

class PostControllerTest extends TestCase
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
        $response = $this->get('/posts');
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
        $response = $this->get('/posts');

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
        
        $response = $this->get('/posts');
        
        $response->assertStatus(200)
            ->assertDontSee('This is closed')
            ->assertSee('This is opened');
    }
    
    /**
     * show_page
     *
     * @return void
     * @test
     */
    public function show_page()
    {
        $post = Post::factory()->create();

        $response = $this->get('posts/'.$post->id);

        $response->assertStatus(200)
            ->assertSee($post->title)
            ->assertSee($post->user->name);
    }
    
    /**
     * can_not_access_closed_article_page
     *
     * @return void
     * @test
     */
    public function can_not_access_closed_article_page()
    {
        $post = Post::factory()->closed()->create();

        $response = $this->get('posts/'.$post->id);
        
        $response->assertStatus(403);
    }
    
    /**
     * only_show_merry_christmas_if_its_1225
     *
     * @return void
     * @test
     */
    public function show_merry_christmas_if_its_1225(){
        Carbon::setTestNow('2020-12-25');

        $response = $this->get('/posts');

        $response->assertStatus(200)
            ->assertSee('merry christmas');
    }

    /**
     * not_show_merry_christmas_if_its_except_1225
     *
     * @return void
     * @test
     */
    public function not_show_merry_christmas_if_its_except_1225(){
        Carbon::setTestNow('2020-12-24');

        $response = $this->get('/posts');

        $response->assertStatus(200)
            ->assertDontSee('merry christmas');
    }
    
    /**
     * show_comments_ordered_by_the_oldest
     *
     * @return void
     * @test
     */
    public function show_comments_ordered_by_the_oldest(){
        $post = Post::factory()->create();
        $first_comment = Comment::factory()->create([
            'created_at' => now()->subDays(2),
            'name' => 'first',
            'post_id' => $post->id,
        ]);

        $secound_comment = Comment::factory()->create([
            'created_at' => now(),
            'name' => 'secound',
            'post_id' => $post->id,
        ]);

        $third_comment = Comment::factory()->create([
            'created_at' => now()->addDays(2),
            'name' => 'third',
            'post_id' => $post->id,
        ]);


        $response = $this->get('posts/'.$post->id);

        $response->assertStatus(200)
            ->assertSee($post->title)
            ->assertSee($post->user->name)
            ->assertSee($secound_comment->name)
            ->assertSee($secound_comment->body)
            ->assertSeeInOrder([
                'first',
                'secound',
                'third',
            ]);
    }
}
