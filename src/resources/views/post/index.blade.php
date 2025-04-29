@extends('layouts.template')

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
                            @if($post->is_active)
                            <span class="btn btn-sm btn-outline-success">{{ __('Active') }}</span>
                            @else
                                <span class="btn btn-sm btn-outline-danger">{{ __('Inactive') }}</span>
                            @endif
                            <div class="mt-3">
                                <b>{{ __('Category') }} {{ $post->category->parent->name }} / {{ $post->category->name }}</b>
                                @if ($post->image)
                                    <div style="background-image: url('{{ asset('images/blog/' . $post->image) }}');" class="bg-image-example"></div>
                                @endif
                                <p>{{ __('Title') }} : {{ $post->title }}<br>
                                    {{ __('Description') }} : {{ $post->description }}</p>
                            </div>
                            <div>
                                <a href="{{ route('posts.edit', $post->id) }}" class="btn btn-warning btn-sm">{{ __('Edit') }}</a>
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
