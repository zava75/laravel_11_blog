<form action="{{ route('posts.search') }}" method="GET" class="d-flex mb-4">
    <input type="text" name="search" class="form-control me-2" placeholder="{{ __('Search by name') }}" value="{{ request()->input('search') }}">
    <button type="submit" class="btn btn-primary">{{ __('Search') }}</button>
</form>
