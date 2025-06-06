@extends('admin.layouts.template')

@section('title', 'Edit category')

@section('description')
    {{ __('Edit category') }}
@endsection

@section('h1', 'Edit category')

@section('content')
    <div class="card p-3">

        <form action="{{ route('categories.update', $category->id) }}" method="POST">
            @method('PUT')
            @csrf

            <div class="mb-3">
                <label for="name" class="form-label">{{ __('Name') }}</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                       name="name" value="{{ old('name', $category->name) }}" minlength="3" maxlength="250" required>
                @error('name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">{{ __('Title') }}</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror" id="title"
                       name="title" value="{{ old('title', $category->title) }}" minlength="3" maxlength="250" required>
                @error('title')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="h1" class="form-label">{{ __('H1') }}</label>
                <input type="text" class="form-control @error('h1') is-invalid @enderror" id="h1"
                       name="h1" value="{{ old('h1', $category->h1) }}" minlength="3" maxlength="250" required>
                @error('h1')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">{{ __('Description') }}</label>
                <textarea class="form-control @error('description') is-invalid @enderror" id="description"
                          name="description" minlength="100" maxlength="255" required>{{ old('description', $category->description) }}</textarea>
                @error('description')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="article" class="form-label">{{ __('Article') }}</label>
                <textarea id="article" name="article" class="form-control" rows="8" maxlength="1000">{{ old('article', $category->article) }}</textarea>
                @error('article')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="parent_id" class="form-label">{{ __('Parent category') }}</label>
                <select class="form-control @error('parent_id') is-invalid @enderror" id="parent_id" name="parent_id">
                    <option value="">{{ __('No') }}</option>
                    @foreach ($parentCategories as $cat)
                        <option value="{{ $cat->id }}" @if ($category->parent_id == $cat->id) selected @endif>
                            {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('parent_id')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3 form-check">
                <input type="hidden" name="is_active" value="0">
                <input type="checkbox" class="form-check-input @error('is_active') is-invalid @enderror" id="is_active" name="is_active" value="1" {{ old('is_active', 1) ? 'checked' : '' }} required>
                <label class="form-check-label" for="is_active">{{ __('Active') }}</label>
                @error('is_active')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">{{ __('Send') }}</button>
        </form>
    </div>
@endsection
