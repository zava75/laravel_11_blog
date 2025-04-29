<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Page\UpdatePageRequest;
use App\Services\CategoryService;
use App\Services\PageService;
use App\Services\PostService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PageController extends Controller
{
    protected PageService $pageService;
    protected CategoryService $categoryService;
    protected PostService $postService;

    public function __construct(PageService $pageService, CategoryService $categoryService, PostService $postService)
    {
        $this->pageService = $pageService;
        $this->categoryService = $categoryService;
        $this->postService = $postService;
    }


    public function index(): View
    {
        $pages = $this->pageService->all();
        return view('admin.page.index', compact('pages'));
    }

    public function show(string $slug): View
    {
        $page = $this->pageService->findBySlug($slug);

        return view('admin.page.show', compact('page'));
    }

    public function home(): View
    {
        $page = $this->pageService->findBySlug('home');
        $posts = $this->postService->getLatestPosts();

        return view('blog.index', compact('page', 'posts'));
    }

    public function edit(string $slug): View
    {
        $page = $this->pageService->findBySlug($slug);
        return view('admin.page.edit', compact('page'));
    }

    public function update(UpdatePageRequest $request, string $slug): RedirectResponse
    {
        $success = $this->pageService->update($slug, $request->validated());
        if ($success) {
            return redirect()
                ->route('pages.index')
                ->with('success', 'Update page');
        }

        return redirect()
            ->route('pages.index')
            ->withErrors(['post' => 'Error updating page']);

    }
}
