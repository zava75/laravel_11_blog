<?php

declare(strict_types=1);

namespace App\Http\Requests\Comment;

use Illuminate\Foundation\Http\FormRequest;

class StoreCommentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }
    protected function prepareForValidation(): void
    {
        if (auth()->check()) {
            $this->merge([
                'guest_name' => auth()->user()->name,
                'guest_email' => auth()->user()->email,
                'user_id' => auth()->id(),
            ]);
        }
    }

    public function rules(): array
    {
        return [
            'post_id' => 'required|int|exists:posts,id',
            'content' => 'required|string|min:10|max:500',

            'guest_name' => 'required|string|min:3|max:255',
            'guest_email' => 'required|email|min:3|max:255',
            'user_id' => 'nullable|int|exists:users,id',
        ];
    }
}
