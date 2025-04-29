@extends('layouts.template')

@section('title', 'Dashboard')

@section('description')
    {{ __('Dashboard description') }}
@endsection

@section('h1', 'Dashboard')

@section('content')
    <div>
        <section class="card p-3 mb-3">
            <header>
                <h2 class="h3 text-dark">
                    {{ __('Profile Information') }}
                </h2>

                <p class="mt-2 text-muted">
                    {{ __("Update your account's profile information and email address.") }}
                </p>
            </header>

            <form id="send-verification" method="post" action="{{ route('verification.send') }}">
                @csrf
            </form>

            <form method="post" action="{{ route('profile.update') }}" class="mt-4">
                @csrf
                @method('patch')

                <div class="mb-3">
                    <label for="name" class="form-label">{{ __('Name') }}</label>
                    <input id="name" name="name" type="text" class="form-control" value="{{ old('name', $user->name) }}" required autofocus autocomplete="name" />
                    @error('name')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="email" class="form-label">{{ __('Email') }}</label>
                    <input id="email" name="email" type="email" class="form-control" value="{{ old('email', $user->email) }}" required autocomplete="username" />
                    @error('email')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror

                    @if ($user instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && !$user->hasVerifiedEmail())
                        <div class="mt-2">
                            <p class="text-muted">
                                {{ __('Your email address is unverified.') }}
                                <button form="send-verification" class="btn btn-link p-0 align-baseline">
                                    {{ __('Click here to re-send the verification email.') }}
                                </button>
                            </p>

                            @if (session('status') === 'verification-link-sent')
                                <p class="mt-2 text-success">
                                    {{ __('A new verification link has been sent to your email address.') }}
                                </p>
                            @endif
                        </div>
                    @endif
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

                    @if (session('status') === 'profile-updated')
                        <p id="saved-message" class="text-muted small mb-0">
                            {{ __('Saved.') }}
                        </p>

                        <script>
                            setTimeout(function() {
                                var message = document.getElementById('saved-message');
                                if (message) {
                                    message.style.display = 'none';
                                }
                            }, 2000);
                        </script>
                    @endif
                </div>
            </form>
        </section>

        <section class="card p-3 mb-3">
            <header>
                <h2 class="h3 text-dark">
                    {{ __('Update Password') }}
                </h2>

                <p class="mt-2 text-muted">
                    {{ __('Ensure your account is using a long, random password to stay secure.') }}
                </p>
            </header>

            <form method="post" action="{{ route('password.update') }}" class="mt-4">
                @csrf
                @method('put')

                <div class="mb-3">
                    <label for="update_password_current_password" class="form-label">{{ __('Current Password') }}</label>
                    <input id="update_password_current_password" name="current_password" type="password" class="form-control" autocomplete="current-password" />
                    @error('current_password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="update_password_password" class="form-label">{{ __('New Password') }}</label>
                    <input id="update_password_password" name="password" type="password" class="form-control" autocomplete="new-password" />
                    @error('password')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-3">
                    <label for="update_password_password_confirmation" class="form-label">{{ __('Confirm Password') }}</label>
                    <input id="update_password_password_confirmation" name="password_confirmation" type="password" class="form-control" autocomplete="new-password" />
                    @error('password_confirmation')
                    <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="d-flex justify-content-between align-items-center">
                    <button type="submit" class="btn btn-primary">{{ __('Save') }}</button>

                    @if (session('status') === 'password-updated')
                        <p id="saved-message" class="text-muted small mb-0">
                            {{ __('Saved.') }}
                        </p>

                        <script>
                            setTimeout(function() {
                                var message = document.getElementById('saved-message');
                                if (message) {
                                    message.style.display = 'none';
                                }
                            }, 2000);
                        </script>
                    @endif
                </div>
            </form>
        </section>

        <section class="card p-3 mb-3">
            <header>
                <h2 class="h3 text-dark">
                    {{ __('Delete Account') }}
                </h2>

                <p class="mt-2 text-muted">
                    {{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Before deleting your account, please download any data or information that you wish to retain.') }}
                </p>
            </header>

            <!-- Delete Account Button -->
            <button class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmUserDeletionModal">
                {{ __('Delete Account') }}
            </button>

            <!-- Modal for Confirmation -->
            <div class="modal fade" id="confirmUserDeletionModal" tabindex="-1" aria-labelledby="confirmUserDeletionModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content p-3">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmUserDeletionModalLabel">{{ __('Are you sure you want to delete your account?') }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <p>{{ __('Once your account is deleted, all of its resources and data will be permanently deleted. Please enter your password to confirm you would like to permanently delete your account.') }}</p>
                        </div>
                            <form method="post" action="{{ route('profile.destroy') }}">
                                @csrf
                                @method('delete')

                                <div class="mb-3">
                                    <label for="password" class="form-label sr-only">{{ __('Password') }}</label>
                                    <input id="password" name="password" type="password" class="form-control" placeholder="{{ __('Password') }}" />
                                    @error('password')
                                    <div class="invalid-feedback d-block">{{ $message }}</div>
                                    @enderror
                                </div>

                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">{{ __('Cancel') }}</button>
                            <button type="submit" class="btn btn-danger ms-3">{{ __('Delete Account') }}</button>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </section>


    </div>
@endsection
