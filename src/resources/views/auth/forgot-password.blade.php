@extends('layouts.template')

@section('title', 'Email Password Reset')

@section('description')
    {{ __('Email Password Reset description') }}
@endsection

@section('h1', 'Email Password Reset')

@section('content')
    <div class="my-5">
        <div class="row">
            <div class="mb-3">
                <p>{{ __('Forgot your password? No problem.') }}<br>
                {{ __('Just let us know your email address and we will email you a password
                          reset link that will allow you to choose a new one.') }}</p>
            </div>
            <div class="col-md-6">
                <form method="POST" action="{{ route('password.email') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="email" class="form-label">{{ __('Email') }}</label>
                        <input id="email" type="email" class="form-control @error('email') is-invalid @enderror"
                               name="email" value="{{ old('email') }}" required autofocus>
                        @error('email')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-start mt-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Email Password Reset Link') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
