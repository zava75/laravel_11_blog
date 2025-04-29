<footer class="bd-footer bg-light text-muted">
    <div class="container p-4">
        <div class="row">
            <div class="col-md-8">
                <h4>{{ __('Latest articles') }}</h4>
                <ul class="list-unstyled">
                    @if($postsLastLimit->count())
                        @foreach($postsLastLimit as $postLastLimit)
                            <li><a href="{{ route('post.show', [ 'category' => $postLastLimit->category->parent->slug,
                                                 'child' => $postLastLimit->category->slug , 'post' => $postLastLimit->slug ]) }}"
                                   class="text-dark">{{ $postLastLimit->name }}</a></li>
                        @endforeach
                    @endif
                </ul>
            </div>
            <div class="col-md-4">
                <h4>{{ __('Information') }}</h4>
                <ul class="list-unstyled">
                    <li><a href="{{ url('/sitemap.xml') }}" class="text-decoration-none text-dark" target="_blank">{{ __('Sitemap') }}</a></li>
                    <li><a href="{{ route('page.show', 'about') }}" class="text-decoration-none text-dark">{{ __('About') }}</a></li>
                    <li><a href="{{ route('page.show', 'contact') }}" class="text-decoration-none text-dark">{{ __('Contact') }}</a></li>
                </ul>
            </div>
        </div>
        <hr class="my-4">
        <div class="text-center">
            <p>Copyright ©
                <script>document.write(new Date().getFullYear())</script>  Laravel v{{ Illuminate\Foundation\Application::VERSION }} (PHP v{{ PHP_VERSION }})
            </p>
        </div>
    </div>
</footer>
