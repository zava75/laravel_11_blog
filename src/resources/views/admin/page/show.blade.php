@extends('layouts.template')

@section('title', optional($page)->title ?? 'Page')

@section('description')
    {{ optional($page)->description ?? 'Page description' }}
@endsection

@section('h1', optional($page)->h1 ?? 'Page')

@section('content')
    <div>
        @if (optional($page)->article)
            <p>{{ $page->article }}</p>
        @endif
    </div>
@endsection
