<div id="sidebar" class="bg-light rounded-lg">
    <div class="card-body py-4">
        <h5 class="mt-3">{{ __('Categories') }}</h5>
        <nav>
            <ul>
                <li>
                    <a href="{{ route('categories.index') }}" class="text-decoration-none link-dark">{{ __('All categories') }}</a>
                </li>
                <li>
                    <a href="{{ route('categories.not-active') }}" class="text-decoration-none link-dark">{{ __('Not active categories') }}</a>
                </li>
                <li>
                    <a href="{{ route('categories.create') }}" class="text-decoration-none link-dark">{{ __('Create category') }}</a>
                </li>
            </ul>
        </nav>
        <hr>
        <h5>{{ __('Posts') }}</h5>
        <nav>
            <ul>
                <li>
                    <a href="{{ route('posts.index') }}" class="text-decoration-none link-dark">{{ __('All posts') }}</a>
                </li>
                <li>
                    <a href="{{ route('posts.not-active') }}" class="text-decoration-none link-dark">{{ __('Not active posts') }}</a>
                </li>
            </ul>
        </nav>
        <hr>
        <h5>{{ __('Pages') }}</h5>
        <nav>
            <ul>
                <li>
                    <a href="{{ route('pages.index') }}" class="text-decoration-none link-dark">{{ __('All pages') }}</a>
                </li>
            </ul>
        </nav>
        <hr>
        <h5>{{ __('Comments') }}</h5>
        <nav>
            <ul>
                <li>
                    <a href="{{ route('comments.index') }}" class="text-decoration-none link-dark">{{ __('All comments') }}</a>
                </li>
                <li>
                    <a href="{{ route('comments.inactive-comments') }}" class="text-decoration-none link-dark">{{ __('All inactive comments') }}</a>
                </li>
            </ul>
        </nav>
    </div>
</div>
