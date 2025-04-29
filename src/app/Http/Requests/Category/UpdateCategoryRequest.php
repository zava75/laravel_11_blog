<?php

declare(strict_types=1);

namespace App\Http\Requests\Category;

use App\Models\Category;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }
    protected function prepareForValidation(): void
    {
        $slug = Str::slug($this->input('name'));
        if (Category::where('slug', $slug)->exists()) {
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
            'h1' => ['required', 'string', 'min:3', 'max:255'],
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['required', 'string', 'min:100', 'max:255'],
            'article' => ['nullable', 'string', 'max:1000'],
            'is_active' => ['required', 'boolean'],
            'parent_id' => ['nullable', 'exists:categories,id'],
            'slug' => ['required', 'string', 'max:255', 'unique:categories,slug'],
        ];
    }
}
