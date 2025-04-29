@extends('admin.layouts.template')

@section('title', 'Pages')

@section('description')
    {{ 'Pages' }}
@endsection

@section('h1', 'Pages')

@section('content')

    <div>
        @if ($pages->isEmpty())
            <p>{{ __('Not pages') }}</p>
        @else
            <ul class="list-group">
                @foreach ($pages as $page)
                    <li class="card my-2 p-3">
                        <div>
                            <h5 class="display-10">{{ $page->name }}</h5>
                            <div>
                                <b>{{ __('Title') }} : {{ $page->title }}</b>
                                <p> {{ __('Description') }} : {{ $page->description }}</p>
                                <hr>
                                <b>{{ __('H1') }} : {{ $page->h1 }}</b>
                                <p> {{ __('Article') }} : {{ $page->article }}</p>
                            </div>
                            <div>
                                <a href="{{ route('pages.edit', $page->slug) }}" class="btn btn-warning btn-sm">{{ __('Edit') }}</a>
                            </div>
                        </div>
                    </li>
                @endforeach
            </ul>
            <div class="d-flex justify-content-start mb-3 mt-3">
                {{ $pages->links('layouts.pagination') }}
            </div>
        @endif
    </div>

@endsection
