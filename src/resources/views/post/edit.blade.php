@extends('layouts.template')

@section('title', 'Edit post: ' . $post->name)

@section('description')
    {{ __('Edit post') }}
@endsection

@section('h1', 'Edit post: ' . $post->name)

@section('content')
    <div class="card p-3">

        @if($post->image)
        <div>
            <label class="form-label">{{ __('Image post') }}</label>
            <div>
                <img src="{{ asset('images/blog/' . $post->image) }}" class="bg-image-example" alt="">
            </div>
            <form action="{{ route('delete-image', $post->id) }}" method="POST" class="d-inline"
                  onsubmit="return confirm('Delete image?')">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger btn-sm mt-2">{{ __('Delete image') }}</button>
            </form>
        </div>
        @endif

        <form action="{{ route('posts.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">{{ __('Name') }}</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror"
                       minlength="3" maxlength="255" id="name" name="name" value="{{ old('name', $post->name) }}" required>
                @error('name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">{{ __('Title') }}</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror"
                       minlength="3" maxlength="255" id="title" name="title" value="{{ old('title', $post->title) }}" required>
                @error('title')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">{{ __('Upload image') }}</label>
                <input type="file" class="form-control @error('image') is-invalid @enderror" id="image" name="image">
                @error('image')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">{{ __('Description') }}</label>
                <textarea class="form-control @error('description') is-invalid @enderror" minlength="100"
                          maxlength="255" id="description" name="description" required>{{ old('description', $post->description) }}</textarea>
                @error('description')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="article" class="form-label">{{ __('Article') }}</label>
                <textarea id="article" name="article" class="form-control" minlength="800"
                          maxlength="2500" rows="8" required>{{ old('article', $post->article) }}</textarea>
                @error('article')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">{{ __('Category') }}</label>
                <select class="form-control @error('category_id') is-invalid @enderror" id="category_id" name="category_id" required>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label class="form-label">{{ __('Tags') }}</label>
                <div>
                    @foreach ($tags as $tag)
                        <div class="form-check form-check-inline">
                            <input class="form-check-input @error('tags') is-invalid @enderror"
                                   type="checkbox"
                                   name="tags[]"
                                   value="{{ $tag->id }}"
                                   id="tag{{ $tag->id }}"
                                {{ (is_array(old('tags')) ? in_array($tag->id, old('tags')) : ($post->tags->contains('id', $tag->id) ?? false)) ? 'checked' : '' }}>
                            <label class="form-check-label" for="tag{{ $tag->id }}">
                                {{ $tag->name }}
                            </label>
                        </div>
                    @endforeach
                </div>
                @error('tags')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">{{ __('Send') }}</button>
        </form>
    </div>
@endsection
