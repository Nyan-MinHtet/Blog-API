<?php

namespace Database\Factories;

use Illuminate\Support\Str;
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
        $content = <<<MARKDOWN
        This is my controller code for GET API. Is it OK?
```php
 public function index()
    {
        \$posts = Post::all()->where('status', 'Public');

        return \$this->successResponse(
            'Success',
            \$posts,
            200
        );
    }
```
MARKDOWN;

        $title = fake()->catchPhrase();
        return [
        'title'     => $title,
        'slug'      => Str::slug($title),
        'content'   => $content,
        'status'    => fake()->randomElement(['Public', 'Private']),
        'user_id'   => rand(1, 11),
        'series_id' => rand(1, 10),
        'category_id' => rand(1, 10),
        ];
    }
}













