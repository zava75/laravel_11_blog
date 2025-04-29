@extends('admin.layouts.template')

@section('title', 'Edit page: ' . $page->name)

@section('description')
    {{ __('Edit page') }}
@endsection

@section('h1', 'Edit page: ' . $page->name)

@section('content')
    <div class="card p-3">

        <form action="{{ route('pages.update', $page->slug) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="mb-3">
                <label for="name" class="form-label">{{ __('Name') }}</label>
                <input type="text" class="form-control @error('name') is-invalid @enderror"
                       minlength="3" maxlength="255" id="name" name="name" value="{{ old('name', $page->name) }}" required>
                @error('name')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="h1" class="form-label">{{ __('H1') }}</label>
                <input type="text" class="form-control @error('h1') is-invalid @enderror"
                       minlength="3" maxlength="255" id="h1" name="h1" value="{{ old('h1', $page->h1) }}" required>
                @error('h1')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="title" class="form-label">{{ __('Title') }}</label>
                <input type="text" class="form-control @error('title') is-invalid @enderror"
                       minlength="3" maxlength="255" id="title" name="title" value="{{ old('title', $page->title) }}" required>
                @error('title')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="description" class="form-label">{{ __('Description') }}</label>
                <textarea class="form-control @error('description') is-invalid @enderror" minlength="100"
                          maxlength="255" id="description" name="description" required>{{ old('description', $page->description) }}</textarea>
                @error('description')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="article" class="form-label">{{ __('Article') }}</label>
                <textarea id="article" name="article" class="form-control" minlength="500"
                          maxlength="1000" rows="8" required>{{ old('article', $page->article) }}</textarea>
                @error('article')
                <div class="text-danger">{{ $message }}</div>
                @enderror
            </div>

            <button type="submit" class="btn btn-primary">{{ __('Send') }}</button>
        </form>
    </div>
@endsection
