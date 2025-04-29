@extends('layouts.template')

@section('title', 'Email Verification')

@section('description')
    {{ __('Verify your email address to continue') }}
@endsection

@section('h1', 'Email Verification Required')

@section('content')
    <div class="my-5">
        <div class="row">
            <div class="col-md-8">
                <div class="mb-3 text-muted">
                    {{ __('Thanks for signing up! Before getting started, could you verify your email address by clicking on the link we just emailed to you? If you didn\'t receive the email, we will gladly send you another.') }}
                </div>

                @if (session('status') == 'verification-link-sent')
                    <div class="alert alert-success">
                        {{ __('A new verification link has been sent to the email address you provided during registration.') }}
                    </div>
                @endif

                <div class="d-flex justify-content-between mt-4">
                    <form method="POST" action="{{ route('verification.send') }}">
                        @csrf
                        <button type="submit" class="btn btn-primary">
                            {{ __('Resend Verification Email') }}
                        </button>
                    </form>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="btn btn-link text-secondary">
                            {{ __('Log Out') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

