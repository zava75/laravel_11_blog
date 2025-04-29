<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Faker\Factory as FakerFactory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $faker = FakerFactory::create('en_EN');
        $name = $faker->words(2, true);

        return [
            'name' => ucfirst($name),
            'slug' => Str::slug($name),
            'title' => $faker->sentence(4),
            'h1' => ucfirst($name),
            'description' => $faker->text(100),
            'article' => $faker->paragraphs(3, true),
            'is_active' => $faker->boolean(90),
            'parent_id' => null,
            'created_at' => now()->subDays(rand(0, 30)),
        ];
    }
}
