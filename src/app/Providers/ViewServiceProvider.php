<?php

declare(strict_types=1);

namespace App\Providers;

use App\Services\CategoryService;
use App\Services\PostService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class ViewServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
    
        if ($this->app->runningInConsole()) {
        return;
        }

        $postsLastLimit = app(PostService::class)->getLatestPostsLimit();
        $menuCategories = app(CategoryService::class)->getMenuCategories();

        View::share(compact('menuCategories', 'postsLastLimit'));

    }
}
