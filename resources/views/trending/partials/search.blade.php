<form
        action="{{ $route ?? route('waterhole.cp.news.index') }}"
        class="lead row gap-xs card card__body"
        role="search"
        style="margin-bottom: 2vh;"
>
    <div class="input-container full-width">
        @icon('tabler-search', ['class' => 'no-pointer'])
        <input
                type="search"
                name="q"
                value="{{ request('q') }}"
                placeholder="Search for latest news by keyword"
                aria-label="{{ __('waterhole::forum.search-placeholder') }}"
                autofocus
        />
    </div>
    <button type="submit" class="btn bg-accent">
        {{ __('waterhole::forum.search-button') }}
    </button>
</form>