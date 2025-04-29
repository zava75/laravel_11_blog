<?php

namespace Database\Factories;

use App\Models\Page;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PageFactory extends Factory
{

    public function definition(): array
    {
        $name = $this->faker->sentence(3);

        return [
            'name' => $name,
            'slug' => Str::slug($name),
            'title' => $this->faker->sentence(),
            'h1' => $this->faker->words(3, true),
            'description' => $this->faker->paragraph(),
            'article' => $this->faker->paragraphs(3, true),
            'is_active' => $this->faker->boolean(80),
        ];
    }
}
