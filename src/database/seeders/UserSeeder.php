<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        // create users from roles admin
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin-laravel-blog@gmail.com',
            'email_verified_at' => now(),
            'password' => Hash::make('admin-laravel-blog'),
            'remember_token' => Str::random(10),
            'role' => 'admin',
            'is_active' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        // create users from roles user & author
        User::factory(50)->create();
    }
}
