<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Http\Requests\Comment\StoreCommentRequest;
use App\Services\CommentService;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CommentController extends Controller
{
    protected CommentService $commentService;
    public function __construct(CommentService $commentService){
        $this->commentService = $commentService;
    }

    public function index(): View
    {
        $comments = $this->commentService->all();

        return view('admin.comment.index', compact('comments'));
    }

        public function allInactiveComments(): View
    {
        $comments = $this->commentService->getInactiveComments();

        return view('admin.comment.inactive', compact('comments'));
    }


    public function store(StoreCommentRequest $request): RedirectResponse
    {
        $success = $this->commentService->create($request->validated());

        if ($success) {
            return redirect()
                ->back()
                ->with('success', 'Comment created');
        }

        return redirect()
            ->back()
            ->withErrors(['post' => 'Error comment created']);
    }

    public function destroy(int $id): RedirectResponse
    {
        $success = $this->commentService->delete($id);

        return $success
            ? redirect()->back()->with('success', 'Comment destroy')
            : redirect()->back()->withErrors('Error');
    }

    public function activate(int $id): RedirectResponse
    {
        $success = $this->commentService->activate($id);

        return $success
            ? redirect()->back()->with('success', 'Comment activate')
            : redirect()->back()->withErrors('Error');
    }

    public function deActivate(int $id): RedirectResponse
    {
        $success = $this->commentService->deActivate($id);

        return $success
            ? redirect()->back()->with('success', 'Comment deactivate')
            : redirect()->back()->withErrors('Error');
    }

}
