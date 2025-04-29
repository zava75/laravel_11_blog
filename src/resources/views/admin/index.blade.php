@extends('admin.layouts.template')

@section('title', 'Admin panel')

@section('description')
{{ __('Admin panel') }}
@endsection

@section('h1', 'Admin panel')

@section('content')
    <div>
{{ __('Admin panel') }}
    </div>
    <div class="py-4">
        <div class="row">
            <!-- Posts -->
            <div class="col-md-4 mb-3">
                <div class="card h-100 bg-light">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('Posts') }}</h5>
                        <p class="card-text">{{ __('Total') }}: {{ $countPosts }}</p>
                        <p class="card-text">{{ __('Active') }}: {{ $countPostsActive }}</p>
                        <p class="card-text">{{ __('Inactive') }}: {{ $countPostsNoActive }}</p>
                    </div>
                </div>
            </div>

            <!-- Users -->
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('Users') }}</h5>
                        <p class="card-text">{{ __('Total') }}: {{ $countUsers }}</p>
                        <p class="card-text">{{ __('Active') }}: {{ $countUsersActive }}</p>
                        <p class="card-text">{{ __('Inactive') }}: {{ $countUsersNoActive }}</p>
                    </div>
                </div>
            </div>

            <!-- Comments -->
            <div class="col-md-4 mb-3">
                <div class="card h-100">
                    <div class="card-body">
                        <h5 class="card-title">{{ __('Comments') }}</h5>
                        <p class="card-text">{{ __('Total') }}: {{ $countComments }}</p>
                        <p class="card-text">{{ __('Active') }}: {{ $countCommentsActive }}</p>
                        <p class="card-text">{{ __('Inactive') }}: {{ $countCommentsNoActive }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
