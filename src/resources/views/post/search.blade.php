@extends('layouts.template')

@section('title', 'Search')

@section('description')
    {{ 'Search description' }}
@endsection

@section('h1', 'Search')

@section('content')
    @include('layouts.search')
    @if ($posts->count())
        @foreach ($posts as $post)
            <article>
                <div class="mb-3 bg-light rounded-lg">
                    @if($post->image)
                        <div class="row" style="margin: 0">
                            <div class="col-md-6 bg-image" style="background-image: url('{{ asset('images/blog/' . $post->image) }}');"></div>
                            <div class="col-md-6">
                                <div class="p-4 d-flex flex-column h-100">
                                    <h5 class="card-title py-4">{{ $post->name }}</h5>
                                    <p>{{ __('Category') }} <a href="{{ route('category.show', ['category' => $post->category->parent->slug,
                                                 'child' => $post->category->slug]) }}">{{ $post->category->name }}</a></p>
                                    <b>{{ __('Author') }} {{ $post->user ? $post->user->name : __('Unknown') }}</b>
                                    @if($post->updated_at)
                                        <p>{{ $post->updated_at->format('d-m-Y') }}</p>
                                    @else
                                        <p>{{ $post->created_at->format('d-m-Y') }}</p>
                                    @endif
                                    <p class="card-text flex-grow-1">{{ $post->description }}</p>
                                    @if($post->tags->count())
                                        <div class="mb-3">
                                            <b>{{ __('Tags :') }}</b>
                                            @foreach($post->tags as $tag)
                                                <b>{{ $tag->name }}</b>
                                            @endforeach
                                        </div>
                                    @endif
                                    <span><a href="{{ route('post.show', [ 'category' => $post->category->parent->slug,
                                                 'child' => $post->category->slug , 'post' => $post->slug ]) }}"
                                             class="btn btn-primary">{{ __('Read me') }}</a></span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="p-4">
                            <h5 class="card-title py-4">{{ $post->name }}</h5>
                            <p>{{ __('Category') }} <a href="{{ route('category.show', ['category' => $post->category->parent->slug,
                                                 'child' => $post->category->slug]) }}">{{ $post->category->name }}</a></p>
                            <b>{{ __('Author') }} {{ $post->user ? $post->user->name : __('Unknown') }}</b>
                            @if($post->updated_at)
                                <p>{{ $post->updated_at->format('d-m-Y') }}</p>
                            @else
                                <p>{{ $post->created_at->format('d-m-Y') }}</p>
                            @endif
                            <p class="card-text">{{ $post->description }}</p>
                            @if($post->tags->count())
                                <div class="mb-3">
                                    <b>{{ __('Tags :') }}</b>
                                    @foreach($post->tags as $tag)
                                        <b>{{ $tag->name }}</b>
                                    @endforeach
                                </div>
                            @endif
                            <span><a href="{{ route('post.show', [ 'category' => $post->category->parent->slug,
                                                 'child' => $post->category->slug , 'post' => $post->slug ]) }}"
                                     class="btn btn-primary">{{ __('Read me') }}</a></span>
                        </div>
                    @endif
                </div>
            </article>
        @endforeach

        <div class="d-flex justify-content-start">
            {{ $posts->links('layouts.pagination') }}
        </div>
    @else
        <p>{{ __('Search no posts') }}</p>
    @endif
@endsection
