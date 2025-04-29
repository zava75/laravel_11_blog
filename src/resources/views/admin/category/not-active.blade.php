@extends('admin.layouts.template')

@section('title', 'Categories not active')

@section('Categories not active')

@endsection

@section('h1', 'Categories not active')

@section('content')
    <div>
        @if ($categories->isEmpty())
            <p>{{ __('No category') }}</p>
        @else
            <ul class="list-group">
                @foreach ($categories as $category)
                    <li class="card my-2 p-3">
                        <div>
                            <h5 class="display-10"><a href="{{ route('category.show', $category->slug) }}" target="_blank">
                                    {{ __('ID') }} : {{ $category->id }} {{ $category->name }}</a></h5>
                            <div>
                                <p>{{ __('Title') }} : {{ $category->title }} <br>
                                    {{ __('Description') }} : {{ $category->description }}</p>
                            </div>
                            <div>
                                <a href="{{ route('categories.edit', $category->id) }}" class="btn btn-warning btn-sm">{{ __('Edit') }}</a>
                                @if (!$category->is_active)
                                    <form action="{{ route('categories.activate', $category->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">{{ __('Activate') }}</button>
                                    </form>
                                @endif
                                <form action="{{ route('categories.destroy', $category->id) }}" method="POST"
                                      class="d-inline" onsubmit="return confirm('Delete category?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">{{ __('Delete') }}</button>
                                </form>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
            <div class="d-flex justify-content-start mb-3 mt-3">
                {{ $categories->links('layouts.pagination') }}
            </div>
        @endif
    </div>
@endsection
