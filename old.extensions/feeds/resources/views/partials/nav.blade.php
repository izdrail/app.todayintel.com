<ul class="nav nav-pills mb-4">
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('feeds.imported') ? 'active'  : '' }}"
           href="{{ route('feeds.index') }}">{{ __('Feeds') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('feeds.import') ? 'active'  : '' }}"
           href="{{ route('feeds.import') }}">{{ __('Feeds Import') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('feeds.search') ? 'active'  : '' }}"
           href="{{ route('feeds.search') }}">{{ __('Explore') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('feeds.allArticles') ? 'active'  : '' }}"
           href="{{ route('feeds.allArticles') }}">{{ __('Latest Articles') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link {{ request()->routeIs('feeds.sync.all') ? 'active'  : '' }}"
           href="{{ route('feeds.sync.all') }}">{{ __('Sync all feeds') }}</a>
    </li>
</ul>
