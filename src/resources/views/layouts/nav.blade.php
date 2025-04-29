<div class="container">
    <nav class="navbar navbar-expand-lg mb-3">
            <a class="navbar-brand" href="{{ route('home') }}">{{ config('app.name') }}</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                    aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a href="{{ route('page.show', 'about') }}" class="nav-link">{{ __('About') }}</a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('page.show', 'contact') }}" class="nav-link">{{ __('Contact') }}</a>
                    </li>

                    @if (Route::has('login'))
                        @auth
                            <li class="nav-item">
                                <a href="{{ route('dashboard') }}" class="nav-link">{{ __('Dashboard') }}</a>
                            </li>
                            <li class="nav-item">
                                <form method="POST" action="{{ route('logout') }}" class="d-inline">
                                    @csrf
                                    <a class="nav-link" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                    this.closest('form').submit();">{{ __('Log out') }}</a>
                                </form>
                            </li>
                        @else
                            <li class="nav-item">
                                <a href="{{ route('login') }}" class="nav-link">{{ __('Log in') }}</a>
                            </li>
                            @if (Route::has('register'))
                                <li class="nav-item">
                                    <a href="{{ route('register') }}" class="nav-link">{{ __('Register') }}</a>
                                </li>
                            @endif
                        @endauth
                    @endif
                </ul>
            </div>
    </nav>
</div>
