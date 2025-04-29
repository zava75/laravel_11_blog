<?php

declare(strict_types=1);

namespace App\Http\Requests\Post;

use App\Models\Post;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class UpdatePostRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    protected function prepareForValidation(): void
    {
        $slug = Str::slug($this->input('name'));
        if (Post::where('slug', $slug)->exists()) {
            $slug .= '-' . uniqid();
        }

        $this->merge([
            'slug' => $slug,
        ]);
    }
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['required', 'string','min:100', 'max:255'],
            'article' => ['required', 'string','min:800', 'max:2500'],
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'category_id' => ['required',
                Rule::exists('categories', 'id')->whereNotNull('parent_id')],
            'slug' => ['required', 'string', 'max:255', 'unique:categories,slug'],
            'tags' => ['required', 'array', 'min:1'],
            'tags.*' => ['integer', 'exists:tags,id'],
        ];
    }
}
