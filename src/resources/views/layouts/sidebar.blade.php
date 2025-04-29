<div id="sidebar" class="bg-light rounded-lg">
    <div class="card-body py-4">
        @auth
            <h5>{{ __('User menu') }}</h5>
            <nav>
                <ul>
                    <li>
                        <a class="text-decoration-none link-dark" href="{{ route('profile.edit') }}">
                            {{ __('Edit profile') }}
                        </a>
                    </li>
                    @if(auth()->user()->isAdmin())
                        <li><a class="text-decoration-none link-dark" href="{{ route('admin.index') }}">Admin Panel</a></li>
                    @endif
                </ul>
            </nav>
            <nav>
                <ul>
                    <li>
                        <a class="text-decoration-none link-dark" href="{{ route('posts-user.index') }}">
                            {{ __('All posts') }}
                        </a>
                    </li>
                    <lI>
                        <a class="text-decoration-none link-dark" href="{{ route('posts-user.create') }}">
                            {{ __('Create post') }}
                        </a>
                    </lI>
                </ul>
            </nav>
            <hr>
        @endauth
        <h5>{{ __('Categories Blog') }}</h5>
        <nav>
            <ul>
                @foreach ($menuCategories as $category)
                    @if ($category->children->isNotEmpty())
                        <li>
                            <a class="text-decoration-none link-dark" href="{{ route('category.show', ['category' => $category->slug]) }}">
                                {{ $category->name }}
                            </a>
                            <ul>
                                @foreach ($category->children as $child)
                                    <li>
                                        <a class="text-decoration-none link-dark" href="{{ route('category.show', ['category' => $category->slug, 'child' => $child->slug]) }}">
                                            {{ $child->name }}
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </li>
                    @else
                        <li>
                            <a class="text-decoration-none link-dark" href="{{ route('category.show', ['category' => $category->slug]) }}">
                                {{ $category->name }}
                            </a>
                        </li>
                    @endif
                @endforeach
            </ul>
        </nav>
    </div>
</div>
