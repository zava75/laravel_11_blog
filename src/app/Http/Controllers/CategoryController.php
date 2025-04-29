<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreCategoryRequest;
use App\Http\Requests\Category\UpdateCategoryRequest;
use App\Services\CategoryService;
use App\Services\PostService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;


class CategoryController extends Controller
{
    protected CategoryService $categoryService;
    protected PostService $postService;

    public function __construct(CategoryService $categoryService, PostService $postService)
    {
        $this->categoryService = $categoryService;
        $this->postService = $postService;
    }

    public function index(): View
    {
        $categories = $this->categoryService->all();

        return view('admin.category.index', compact('categories'));
    }

    public function getInactiveCategories(): View
    {
        $categories = $this->categoryService->getInactiveCategories();

        return view('admin.category.not-active', compact('categories'));
    }

    public function create(): View
    {
        $categories = $this->categoryService->getRootCategories();

        return view('admin.category.create', compact('categories'));
    }

    public function store(StoreCategoryRequest $request): RedirectResponse
    {
        $success = $this->categoryService->create($request->validated());

        if ($success) {
            return redirect()
                ->route('categories.index')
                ->with('success', 'Category created');
        }

        return redirect()
            ->route('categories.index')
            ->withErrors(['category' => 'Error creating category']);
    }

    public function show(string $parent, ?string $child = null): View
    {
        $categorySlug = $child ?? $parent;
        $category = $this->categoryService->getCategoryBySlug($categorySlug);
        $posts = $this->postService->getPostsCategory($category);

        return view('category.show', compact('category','posts'));
    }

    public function edit(int $id): View
    {
        $category = $this->categoryService->find($id);
        $parentCategories = $this->categoryService->getRootCategoriesExcept($id);
        return view('admin.category.edit', compact('category', 'parentCategories'));
    }

    public function update(UpdateCategoryRequest $request, int $id):RedirectResponse
    {
        $success = $this->categoryService->update($id, $request->validated());

        if ($success) {
            return redirect()
                ->route('categories.index')
                ->with('success', 'Category updated');
        }

        return redirect()
            ->route('categories.index')
            ->withErrors(['category' => 'Error updating category']);
    }

    public function destroy(int $id): RedirectResponse
    {
        $success = $this->categoryService->delete($id);

        if ($success) {
            return redirect()
                ->route('categories.index')
                ->with('success', 'Category destroyed');
        }

        return redirect()
            ->route('categories.index')
            ->withErrors(['category' => 'Error deleting category']);
    }

    public function activate(int $id): RedirectResponse
    {
        $success = $this->categoryService->activate($id);

        if ($success) {
            return redirect()->back()->with('success', 'Category activated');
        }

        return redirect()->back()->withErrors(['category' => 'Error activating category']);
    }

    public function deactivate(int $id): RedirectResponse
    {
        $success = $this->categoryService->deactivate($id);

        if ($success) {
            return redirect()->back()->with('success', 'Category deactivated');
        }

        return redirect()->back()->withErrors(['category' => 'Error deactivating category']);
    }
}
