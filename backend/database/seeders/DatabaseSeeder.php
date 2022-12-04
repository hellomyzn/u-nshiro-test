<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Post;
use App\Models\Comment;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // User::factory(10)->create();
        // Post::factory(30)->create();
        

        User::factory(10)->create()->each(function($user) {
            Post::factory(random_int(2,5))->create(['user_id' => $user->id])->each(function($post){
                Comment::factory(random_int(0,3))->create(['post_id' => $post->id]);
            });
        });

        // Comment::factory(100)->create();
        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
