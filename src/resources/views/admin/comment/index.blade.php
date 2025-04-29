@extends('admin.layouts.template')

@section('title', 'Comments')

@section('Comments')

@endsection

@section('h1', 'Comments')

@section('content')
    <div>
        @if ($comments->isEmpty())
            <p>{{ __('No comment') }}</p>
        @else
            <ul class="list-group">
                @foreach ($comments as $comment)
                    <li class="card my-2 p-3">
                        <div>
                            <h5 class="display-10"><a href="" target="_blank">
                                    {{ __('ID') }} : {{ $comment->id }} {{ $comment->name }}</a> </h5>
                            <div>
                                <b>{{ __('Post') }} : {{ $comment->post->name }}</b>
                                <p>{{ __('Author') }} : {{ $comment->guest_name }} : {{ $comment->guest_email }}</p>
                                @if($comment->user_id)
                                    <p class="btn btn-sm btn-outline-primary">{{ __('User') }}</p>
                                @else
                                    <p class="btn btn-sm btn-outline-warning">{{ __('Guest') }}</p>
                                @endif
                                <p>{{ __('Content') }} : {{ $comment->content }}</p>
                            </div>
                            <div>
                                @if (!$comment->is_active)
                                    <form action="{{ route('comments.activate', $comment->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm">{{ __('Activate') }}</button>
                                    </form>
                                @else
                                    <form action="{{ route('comments.deactivate', $comment->id) }}" method="POST" style="display:inline;">
                                        @csrf
                                        <button type="submit" class="btn btn-secondary btn-sm">{{ __('Deactivate') }}</button>
                                    </form>
                                @endif
                                <form action="{{ route('comments.destroy', $comment->id) }}" method="POST"
                                      class="d-inline" onsubmit="return confirm('Delete comment?')">
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
                {{ $comments->links('layouts.pagination') }}
            </div>
        @endif
    </div>
@endsection
