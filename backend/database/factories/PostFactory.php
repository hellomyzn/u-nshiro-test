<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

use App\Models\User;
use App\Models\Post;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        
        return [
            'user_id' => User::factory(),
            'status' => Post::OPEN,
            'title' => $this->faker->realText(20),
            'body' => $this->faker->realText(200),
        ];
    }

    public function random()
    {
        return $this->state(function(array $attributes) {
            return [
                'status' => fake()->randomElement([
                    Post::OPEN,
                    Post::OPEN,
                    Post::OPEN,
                    Post::OPEN,
                    Post::CLOSE,
                ])
            ];
        });
    }

    public function closed()
    {
        return $this->state(function(array $attributes) {
            return [
                'status' => Post::CLOSE,
            ];
        });
    }
}
