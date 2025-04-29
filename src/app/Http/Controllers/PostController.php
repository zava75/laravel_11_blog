<?php

declare(strict_types=1);

namespace App\Http\Controllers;
use App\Http\Requests\Post\StorePostRequest;
use App\Http\Requests\Post\UpdatePostRequest;
use App\Services\CategoryService;
use App\Services\CommentService;
use App\Services\PostService;
use App\Services\TagService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    protected PostService $postService;
    protected CategoryService $categoryService;

    protected CommentService $commentService;

    protected TagService $tagService;

    public function __construct(PostService $postService, CategoryService $categoryService,
                                CommentService $commentService, TagService $tagService)
    {
        $this->postService = $postService;
        $this->categoryService = $categoryService;
        $this->commentService = $commentService;
        $this->tagService = $tagService;
    }

//    FRONT
    public function show(string $categorySlug, string $childSlug, string $postSlug): View
    {
        $post = $this->postService->show($postSlug);
        $category = $post->category;
        $parentCategory = $category->parent;
        $comments = $this->commentService->postAllComments($post->id);
        $tags = $post->tags;

        if ($parentCategory->slug !== $categorySlug ||  $category->slug !== $childSlug) {
            abort(404);
        }
        if (!$category->is_active || !$parentCategory->is_active) {
            abort(404);
        }

        $randomPosts = $this->postService->getRandomPostsCategory($category->id, $post->id);

        return view('post.show', compact('post', 'randomPosts', 'comments'));
    }

//    USER
    public function indexPostsUser(): View
    {
        $posts = $this->postService->allPostsUser();

        return view('post.index', compact('posts'));
    }

    public function create(): View
    {
        $categories = $this->categoryService->getSubCategories();
        $tags = $this->tagService->all();

        return view('post.create', compact('categories', 'tags'));
    }

    public function store(StorePostRequest $request): RedirectResponse
    {

        $data = $request->validated();
        $tags = $data['tags'];
        $success = $this->postService->create($data, $tags);

        $redirectRoute = $this->getPostsIndexRouteByRole();

        if ($success) {
            return redirect()
                ->route($redirectRoute)
                ->with('success', 'Post created');
        }

        return redirect()
            ->route($redirectRoute)
            ->withErrors(['post' => 'Error post created']);
    }

    public function edit(int $id): View
    {
        $categories = $this->categoryService->getSubCategories();
        $post = $this->postService->find($id);
        $tags = $this->tagService->all();

        return view('post.edit', compact('post','categories', 'tags'));
    }

    public function update(UpdatePostRequest $request, int $id): RedirectResponse
    {
        $data = $request->validated();
        $tags = $data['tags'];
        $success = $this->postService->update($id, $data, $tags);

        $redirectRoute = $this->getPostsIndexRouteByRole();

        if ($success) {
            return redirect()
                ->route($redirectRoute)
                ->with('success', 'Update post');
        }

        return redirect()
            ->route($redirectRoute)
            ->withErrors(['post' => 'Error updating post']);
    }

//    ADMIN

    public function index(): View
    {
        $posts = $this->postService->all();

        return view('admin.post.index', compact('posts'));
    }

    public function getInactivePosts(): View
    {
        $posts = $this->postService->getInactivePosts();

        return view('admin.post.not-active', compact('posts'));
    }

    public function destroy(int $id):RedirectResponse
    {
        $success = $this->postService->delete($id);

        return $success
            ? redirect()->back()->with('success', 'Post destroy')
            : redirect()->back()->withErrors('Error');
    }

    public function activate(int $id): RedirectResponse
    {
        $success = $this->postService->activate($id);

        return $success
            ? redirect()->back()->with('success', 'Post activate')
            : redirect()->back()->withErrors('Error');
    }

    public function deactivate(int $id): RedirectResponse
    {
        $success = $this->postService->deactivate($id);

        return $success
            ? redirect()->back()->with('success', 'Post deactivate')
            : redirect()->back()->withErrors('Error');
    }

    public function deleteImage(int $id):RedirectResponse
    {
        $success = $this->postService->deleteImage($id);

        return $success
            ? redirect()->back()->with('success', 'Image removed')
            : redirect()->back()->withErrors('Image delete failed');
    }

    private function getPostsIndexRouteByRole(): string
    {
        return auth()->user()->isAdmin() ? 'posts.index' : 'posts-user.index';
    }

    public function search(Request $request): View
    {
        $search = (string) $request->input('search');
        $posts = $this->postService->search($search);

        return view('post.search', compact('posts'));
    }
}
