<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    public function run(): void
    {

        Page::create([
            'name' => 'Home',
            'slug' => 'home',
            'title' => 'Welcome to Home Blog Laravel - Your Ultimate Source for Laravel Insights',
            'h1' => 'Home Blog Laravel - Stay Updated with the Latest Laravel Tips and Tutorials',
            'description' => 'Home Blog Laravel is your go-to platform for all things Laravel. Explore tutorials, tips, and articles to help you build better applications using Laravel. Stay updated with the latest Laravel news and resources.',
            'article' => 'Welcome to Home Blog Laravel! Here, we offer a comprehensive collection of articles and tutorials that cover everything from beginner concepts to advanced Laravel techniques. Whether you are new to Laravel or a seasoned developer, you’ll find valuable insights that can help you enhance your Laravel applications. From step-by-step guides to expert tips, Home Blog Laravel has it all. Join our community and learn Laravel with us!',
            'is_active' => true,
        ]);

        Page::create([
            'name' => 'About',
            'slug' => 'about',
            'title' => 'About Home Blog Laravel',
            'h1' => 'About Blog Laravel',
            'description' => 'Home Blog Laravel is a platform designed to share the best Laravel tutorials and tips. Get to know more about the vision and mission of our platform.',
            'article' => 'Home Blog Laravel started as a small blog with the vision to provide the best Laravel tutorials for developers at any level. Our mission is to simplify Laravel development by providing clear and comprehensive guides, tutorials, and tips.',
            'is_active' => true,
        ]);

        Page::create([
            'name' => 'Contact',
            'slug' => 'contact',
            'title' => 'Contact Us Blog Laravel',
            'h1' => 'Contact Us Blog Laravel',
            'description' => 'Have questions or feedback? Feel free to reach out to us. We’d love to hear from you.',
            'article' => 'If you have any questions, suggestions, or feedback, feel free to contact us. You can reach us via email at support@homebloglaravel.com or use the contact form on our website.',
            'is_active' => true,
        ]);
    }
}
