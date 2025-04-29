@extends('layouts.template')

@section('title', $post->title ?? 'Title post')

@section('description')
    {{ $post->description ?? 'Post description' }}
@endsection

@section('h1', $post->name ?? 'Post H1')

@section('content')
    <nav style="--bs-breadcrumb-divider: '>';" aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('Home') }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('category.show', ['category' => $post->category->parent->slug]) }}">{{ $post->category->parent->name }}</a></li>
            <li class="breadcrumb-item"><a href="{{ route('category.show', ['category' => $post->category->parent->slug, 'child' => $post->category->slug]) }}">{{ $post->category->name }}</a></li>
            <li class="breadcrumb-item active" aria-current="page">{{ $post->name }}</li>
        </ol>
    </nav>

    @include('layouts.search')

    <div>
        @if ($post->image)
           <img src="{{ asset('images/blog/' . $post->image) }}" alt="{{ $post->name }}">
        @endif
        <p class="mt-3">{{ __('Author') }} {{ $post->user ? $post->user->name : __('Unknown') }}</p>
        @if($post->updated_at)
            <p>{{ $post->updated_at->format('d-m-Y') }}</p>
        @else
            <p>{{ $post->created_at->format('d-m-Y') }}</p>
        @endif
        @if ($post->article)
            <p class="my-3">{{ $post->article }}</p>
        @endif
        <div>
            <h6>{{ __('Tags :') }}</h6>
            @if($post->tags->count())
                @foreach($post->tags as $tag)
                    <b class="btn btn-sm btn-outline-primary mb-1">{{ $tag->name }}</b>
                @endforeach
            @else
                <span>{{ __('No tags') }}</span>
            @endif
        </div>
    </div>
    <div class="card my-3 p-4">
        <h4 class="display-10">{{ __('Comments') }}</h4>
        @if($comments->count())
            @foreach($comments as $comment)
                <div class="my-3">
                    <b>{{ $comment->guest_name }}</b>
                    <p>{{ $comment->content }}<br>{{ $comment->created_at->format('d-m-Y') }}</p>
                </div>
            @endforeach
        @else
            {{ __('No comments') }}
        @endif
        <hr>
            <div class="mt-3">
                <h6>{{ __('Leave a Comment') }}</h6>
                <form action="{{ route('comments.store') }}" method="POST">
                    @csrf

                    <input type="hidden" name="post_id" value="{{ $post->id }}">

                    @guest
                        <div class="mb-3">
                            <label for="guest_name" class="form-label">{{ __('Name') }}</label>
                            <input type="text" class="form-control @error('guest_name') is-invalid @enderror" id="guest_name" name="guest_name" required>
                            @error('guest_name')
                            <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>

                        <div class="mb-3">
                            <label for="guest_email" class="form-label">{{ __('Email') }}</label>
                            <input type="email" class="form-control @error('guest_email') is-invalid @enderror" id="guest_email" name="guest_email" required>
                            @error('guest_email')
                            <div class="invalid-feedback">{{ $message }}</div> @enderror
                        </div>
                    @endguest

                    <div class="mb-3">
                        <label for="content" class="form-label">{{ __('Comment') }}</label>
                        <textarea class="form-control @error('content') is-invalid @enderror" id="content" name="content" rows="4" minlength="10" maxlength="500" required></textarea>
                        @error('content')
                        <div class="invalid-feedback">{{ $message }}</div> @enderror
                    </div>

                    <button type="submit" class="btn btn-primary">{{ __('Send') }}</button>
                </form>
        </div>
    </div>
    <h4 class="display-10">{{ __('Popular post') }}</h4>
    @if ($randomPosts->count())
        @foreach ($randomPosts as $randomPost)
            <article>
                <div class="mb-3 bg-light rounded-lg">
                    @if($randomPost->image)
                        <div class="row" style="margin: 0">
                            <div class="col-md-6 bg-image" style="background-image: url('{{ asset('images/blog/' . $randomPost->image) }}');"></div>
                            <div class="col-md-6">
                                <div class="p-4 d-flex flex-column h-100">
                                    <h5 class="card-title py-4">{{ $randomPost->name }}</h5>
                                    <p>{{ __('Category') }} <a href="{{ route('category.show', ['category' => $post->category->parent->slug,
                                                 'child' => $post->category->slug]) }}" class="">{{ $randomPost->category->name }}</a></p>
                                    <b>{{ __('Author') }} {{ $randomPost->user ? $post->user->name : __('Unknown') }}</b>
                                    @if($randomPost->updated_at)
                                        <p>{{ $randomPost->updated_at->format('d-m-Y') }}</p>
                                    @else
                                        <p>{{ $randomPost->created_at->format('d-m-Y') }}</p>
                                    @endif
                                    <p class="card-text flex-grow-1">{{ $randomPost->description }}</p>
                                    @if($post->tags->count())
                                        <div class="mb-3">
                                            <b>{{ __('Tags :') }}</b>
                                            @foreach($post->tags as $tag)
                                                <b>{{ $tag->name }}</b>
                                            @endforeach
                                        </div>
                                    @endif
                                    <span><a href="{{ route('post.show', [ 'category' => $randomPost->category->parent->slug,
                                                 'child' => $randomPost->category->slug , 'post' => $randomPost->slug ]) }}"
                                             class="btn btn-primary">{{ __('Read me') }}</a></span>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="p-4">
                            <h5 class="card-title py-4">{{ $randomPost->name }}</h5>
                            <p>{{ __('Category') }} <a href="" class="">{{ $randomPost->category->name }}</a></p>
                            <b>{{ __('Author') }} {{ $randomPost->user ? $post->user->name : __('Unknown') }}</b>
                            @if($randomPost->updated_at)
                                <p>{{ $randomPost->updated_at->format('d-m-Y') }}</p>
                            @else
                                <p>{{ $randomPost->created_at->format('d-m-Y') }}</p>
                            @endif
                            <p class="card-text">{{ $randomPost->description }}</p>
                            @if($post->tags->count())
                                <div class="mb-3">
                                    <b>{{ __('Tags :') }}</b>
                                    @foreach($post->tags as $tag)
                                        <b>{{ $tag->name }}</b>
                                    @endforeach
                                </div>
                            @endif
                            <span><a href="{{ route('post.show', [ 'category' => $randomPost->category->parent->slug,
                                                 'child' => $randomPost->category->slug , 'post' => $randomPost->slug ]) }}"
                                     class="btn btn-primary">{{ __('Read me') }}</a></span>
                        </div>
                    @endif
                </div>
            </article>
        @endforeach
    @else
        <p>{{ __('Not post') }}</p>
    @endif
@endsection
