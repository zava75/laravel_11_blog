@extends('admin.layouts.template')

@section('title', 'Categories')

@section('Categories')

@endsection

@section('h1', 'Categories')

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
                                    {{ __('ID') }} : {{ $category->id }} {{ $category->name }}</a> {{ $category->posts_count }} {{ __('post') }} </h5>
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
                                @else
                                    <form action="{{ route('categories.deactivate', $category->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-secondary btn-sm">{{ __('Deactivate') }}</button>
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
                    @if ($category->children->isNotEmpty())
                        <ul class="list-group">
                            @foreach ($category->children as $child)
                                <li class="card ms-4 my-2 p-3">
                                    <div>
                                        <h5 class="display-10"><a href="{{ route('category.show', ['category' => $category->slug, 'child' => $child->slug]) }}"
                                                                  target="_blank">{{ $category->name }} / {{ __('ID') }} : {{ $child->id }} {{ $child->name }}</a>
                                            {{ $child->posts_count }} {{ __('post') }}</h5>
                                        <div>
                                            <p>{{ __('Title') }} : {{ $child->title }} <br>
                                                {{ __('Description') }} : {{ $child->description }}</p>
                                        </div>
                                        <div>
                                            <a href="{{ route('categories.edit', $child->id) }}" class="btn btn-warning btn-sm">{{ __('Edit') }}</a>
                                            @if (!$child->is_active)
                                                <form action="{{ route('categories.activate', $child->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-success btn-sm">{{ __('Activate') }}</button>
                                                </form>
                                            @else
                                                <form action="{{ route('categories.deactivate', $child->id) }}" method="POST" style="display:inline;">
                                                    @csrf
                                                    <button type="submit" class="btn btn-secondary btn-sm">{{ __('Deactivate') }}</button>
                                                </form>
                                            @endif
                                            <form action="{{ route('categories.destroy', $child->id) }}" method="POST"
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
                    @endif
                @endforeach
            </ul>
            <div class="d-flex justify-content-start mb-3 mt-3">
                {{ $categories->links('layouts.pagination') }}
            </div>
        @endif
    </div>
@endsection
