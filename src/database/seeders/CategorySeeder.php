<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $parents = Category::factory(6)->create();
        Category::factory(15)->create([
            'parent_id' => $parents->random()->id,
        ]);
    }
}
