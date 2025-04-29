<?php

declare(strict_types=1);

namespace App\Http\Requests\Page;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePageRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check() && auth()->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:3', 'max:255'],
            'title' => ['required', 'string', 'min:3', 'max:255'],
            'h1' => ['required', 'string', 'min:3', 'max:255'],
            'description' => ['required', 'string','min:100', 'max:255'],
            'article' => ['required', 'string','min:500', 'max:1000'],
        ];
    }

}
