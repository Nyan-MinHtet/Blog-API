<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

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
    public function definition(): array
    {
        return [
        'title'     => fake()->name,
        'slug'      => fake()->slug,
        'content'   => fake()->text,
        'status'    => fake()->randomElement(['Public', 'Private']),
        'user_id'   => rand(1, 11),
        'series_id' => rand(1, 10),
        'categories_id' => rand(1, 10),
        ];
    }
}
