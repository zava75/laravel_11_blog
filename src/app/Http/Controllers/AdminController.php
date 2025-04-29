<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Services\CommentService;
use App\Services\PostService;
use App\Services\UserService;
use Illuminate\View\View;

class AdminController extends Controller
{
    protected PostService $postService;
    protected UserService $userService;
    protected CommentService $commentService;
    public function __construct(PostService $postService, UserService $userService, CommentService $commentService)
    {
        $this->postService = $postService;
        $this->userService = $userService;
        $this->commentService = $commentService;
    }

    public function __invoke():View
    {
        $countPosts = $this->postService->totalPosts();
        $countPostsActive = $this->postService->totalPostsActive();
        $countPostsNoActive = $this->postService->totalPostsNoActive();

        $countUsers = $this->userService->totalUsers();
        $countUsersActive = $this->userService->totalUsersActive();
        $countUsersNoActive = $this->userService->totalUsersNoActive();

        $countComments = $this->commentService->totalComments();
        $countCommentsActive = $this->commentService->totalCommentsActive();
        $countCommentsNoActive = $this->commentService->totalCommentsNoActive();

        return view('admin.index', compact('countPosts', 'countPostsActive',
            'countPostsNoActive', 'countUsers', 'countUsersActive', 'countUsersNoActive',
            'countComments', 'countCommentsActive', 'countCommentsNoActive'));
    }
}
