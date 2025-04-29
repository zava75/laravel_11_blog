@extends('layouts.template')

@section('title', 'Confirm Your Password')

@section('description')
    {{ __('Confirm Your Password description') }}
@endsection

@section('h1', 'Confirm Your Password')

@section('content')
    <div class="my-5">
        <div class="row">
            <div class="mb-3">
                <p>{{ __('This is a secure area of the application. Please confirm your password before continuing.') }}</p>
            </div>
            <div class="col-md-6">
                <form method="POST" action="{{ route('password.confirm') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="password" class="form-label">{{ __('Password') }}</label>
                        <input id="password" type="password"
                               class="form-control @error('password') is-invalid @enderror"
                               name="password" required autocomplete="current-password">
                        @error('password')
                        <div class="invalid-feedback">
                            {{ $message }}
                        </div>
                        @enderror
                    </div>

                    <div class="d-flex justify-content-start mt-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Confirm') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
