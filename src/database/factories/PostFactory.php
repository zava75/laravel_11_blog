<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Faker\Factory as FakerFactory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = FakerFactory::create('en_EN');
        $wordCount = rand(4, 7);
        $name = ucfirst($faker->words($wordCount, true));

        $createdAt = $faker->dateTimeBetween('-120 days', 'now');
        $updatedAt = $faker->boolean(20) ? $faker->dateTimeBetween($createdAt, 'now') : null;

        return [
            'name' => $name,
            'slug' => function (array $attributes) {
                return Str::slug($attributes['name'], '-');
            },
            'category_id' => Category::whereNotNull('parent_id')->inRandomOrder()->first()?->id ?? Category::factory(),
            'user_id' => User::inRandomOrder()->first()?->id ?? User::factory(),
            'title' => $name,
            'description' => $faker->realText(230),
            'image' => $faker->boolean(70) ? 'demo/' . $faker->numberBetween(1, 30) . '.jpg' : null,
            'article' => $faker->realText(1600),
            'is_active' => $faker->boolean(90),
            'created_at' => $createdAt,
            'updated_at' => $updatedAt,
        ];
    }
}
