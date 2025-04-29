<?php

namespace Database\Factories;

use App\Models\Comment;
use App\Models\Post;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    protected $model = Comment::class;

    public function definition(): array
    {
        $user = $this->faker->boolean(50) ? User::inRandomOrder()->first() : null;

        return [
            'post_id' => Post::query()->where('is_active', true)->inRandomOrder()->value('id'),
            'user_id' => $user?->id,
            'guest_name' => $user ? $user->name : $this->faker->name,
            'guest_email' => $user ? $user->email : $this->faker->email,
            'content' => $this->faker->paragraph(),
            'is_active' => $this->faker->boolean(90),
            'created_at' => now()->subDays(rand(0, 30)),
        ];
    }
}
