<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PageController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProfileController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Support\Facades\Route;

Route::get('/', [PageController::class, 'home'])->name('home');
Route::get('/page/{slug}', [PageController::class, 'show'])->name('page.show');
Route::post('comments', [CommentController::class, 'store'])->name('comments.store');
Route::get('/search', [PostController::class, 'search'])->name('posts.search');

Route::middleware(['auth', 'verified'])->prefix('dashboard')->group(function () {

    Route::get('/', function () {
        return view('profile.dashboard');
    })->name('dashboard');

    Route::get('posts', [PostController::class, 'indexPostsUser'])->name('posts-user.index');
    Route::get('posts/create', [PostController::class, 'create'])->name('posts-user.create');
    Route::post('posts', [PostController::class, 'store'])->name('posts.store');
    Route::get('posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit');
    Route::put('posts/{post}', [PostController::class, 'update'])->name('posts.update');
    Route::delete('posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');
    Route::delete('posts/{post}/delete-image', [PostController::class, 'deleteImage'])->name('delete-image');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

});

Route::middleware(['auth', AdminMiddleware::class])->prefix('admin')->group(function () {

    Route::get('/', AdminController::class)->name('admin.index');

    Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
    Route::get('categories/not-active', [CategoryController::class, 'getInactiveCategories'])->name('categories.not-active');
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create');
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store');
    Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit');
    Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');
    Route::post('categories/{category}/activate', [CategoryController::class, 'activate'])->name('categories.activate');
    Route::post('categories/{category}/deactivate', [CategoryController::class, 'deactivate'])->name('categories.deactivate');

    Route::get('posts', [PostController::class, 'index'])->name('posts.index');
    Route::get('posts/not-active', [PostController::class, 'getInactivePosts'])->name('posts.not-active');
    Route::get('posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit-admin');;
    Route::put('posts/{post}', [PostController::class, 'update'])->name('posts.update-admin');
    Route::delete('posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy-admin');
    Route::post('posts/{post}/activate', [PostController::class, 'activate'])->name('posts.activate');
    Route::post('posts/{post}/deactivate', [PostController::class, 'deactivate'])->name('posts.deactivate');
    Route::delete('posts/{post}/delete-image', [PostController::class, 'deleteImage'])->name('delete-image-admin');

    Route::get('pages', [PageController::class, 'index'])->name('pages.index');
    Route::get('pages/{page}/edit', [PageController::class, 'edit'])->name('pages.edit');
    Route::put('pages/{page}', [PageController::class, 'update'])->name('pages.update');

    Route::get('comments', [CommentController::class, 'index'])->name('comments.index');
    Route::get('comments/inactive-comments', [CommentController::class, 'allInactiveComments'])->name('comments.inactive-comments');
    Route::delete('comments/{comments}', [CommentController::class, 'destroy'])->name('comments.destroy');
    Route::post('comments/{comments}/activate', [CommentController::class, 'activate'])->name('comments.activate');
    Route::post('comments/{comments}/deactivate', [CommentController::class, 'deActivate'])->name('comments.deactivate');
});

require __DIR__.'/auth.php';

Route::get('{category}/{child?}', [CategoryController::class, 'show'])
    ->where('category', '[a-zA-Z0-9-_]+')
    ->where('child', '[a-zA-Z0-9-_]+')
    ->name('category.show');

Route::get('{category}/{child}/{post}', [PostController::class, 'show'])->name('post.show');
