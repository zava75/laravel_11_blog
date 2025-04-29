@extends('admin.layouts.template')

@section('title', 'Posts')

@section('Posts')

@endsection

@section('h1', 'Posts')

@section('content')
    <div>
        @if ($posts->isEmpty())
            <p>{{ __('No post') }}</p>
        @else
            <ul class="list-group">
                @foreach ($posts as $post)
                    <li class="card my-2 p-3">
                        <div>
                            <h5 class="display-10"><a href="{{ route('post.show',['category' => $post->category->parent->slug,
                                         'child' => $post->category->slug, 'post' => $post->slug]) }}" target="_blank">
                                    {{ __('ID') }} : {{ $post->id }} {{ $post->name }}</a> </h5>
                            <div>
                                <b>{{ __('Category') }} : {{ $post->category->parent->name }} / {{ $post->category->name }}</b>
                                <p>{{ __('Author') }} : {{ $post->user->name }}</p>
                                @if ($post->image)
                                    <div style="background-image: url('{{ asset('images/blog/' . $post->image) }}');" class="bg-image-example"></div>
                                @endif
                                <p>{{ __('Title') }} : {{ $post->title }} <br>
                                    {{ __('Description') }} : {{ $post->description }}</p>
                            </div>
                            @if($post->tags->count())
                                <div class="mb-3">
                                    <b>{{ __('Tags :') }}</b>
                                    @foreach($post->tags as $tag)
                                        <b>{{ $tag->name }}</b>
                                    @endforeach
                                </div>
                            @endif
                            <div>
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning btn-sm">{{ __('Edit') }}</a>
                                @if (!$post->is_active)
                                    <form action="{{ route('posts.activate', $post->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">{{ __('Activate') }}</button>
                                    </form>
                                @else
                                    <form action="{{ route('posts.deactivate', $post->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-secondary btn-sm">{{ __('Deactivate') }}</button>
                                    </form>
                                @endif
                                <form action="{{ route('posts.destroy', $post->id) }}" method="POST"
                                      class="d-inline" onsubmit="return confirm('Delete post?')">
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
                {{ $posts->links('layouts.pagination') }}
            </div>
        @endif
    </div>
@endsection
