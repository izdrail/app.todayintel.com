<x-waterhole::cp :title="__('Ai rewriter')">

    <h2>
        Rewrite AI chat
    </h2>
    <p>
        Rewrite AI chat is a tool that allows you to rewrite your text using AI.
    </p>
    <p>
        We are using Lama Model 7B for rewriting your text.
    </p>

    <form method="post">
    <x-waterhole::text-editor
            name="body"
            value="Hello, world!"
            placeholder="Enter your text"
            class="input"
    />


        <button class="btn push-end justify-end">
            @icon('tabler-pencil')
            Rewrite
        </button>
        <div class="post-feed__toolbar row wrap-reverse justify-end gap-sm">
            <div class="row">
                <div class="tabs hide-sm">
                    <a class="is-active tab" href="http://todayintel.loc/channels/trending?filter=latest">
                        <span class="label">Latest</span>

                    </a>
                    <a class="tab" href="http://todayintel.loc/channels/trending?filter=newest">
                        <span class="label">Newest</span>

                    </a>
                    <a class="tab" href="http://todayintel.loc/channels/trending?filter=trending">
                        <span class="label">Trending</span>

                    </a>
                    <a class="tab" href="http://todayintel.loc/channels/trending?filter=top">
                        <span class="label">Top</span>

                    </a>

                </div>

                <div class="tabs hide-md-up">
                    <ui-popup class="hide-md-up" placement="bottom-start">
                        <button type="button" class="tab" aria-expanded="false" aria-haspopup="true">
                            <span>Latest</span>
                            <svg class="icon--narrow icon icon-tabler-selector" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                <path d="M8 9l4 -4l4 4"></path>
                                <path d="M16 15l-4 4l-4 -4"></path>
                            </svg>            </button>

                        <ui-menu class="menu" hidden="" role="menu" tabindex="-1">
                            <a href="http://todayintel.loc/channels/trending?filter=latest" class="menu-item" role="menuitemradio" aria-checked="true">
                                Latest
                                <svg class="menu-item__check icon icon-tabler-check" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path d="M5 12l5 5l10 -10"></path>
                                </svg>                            </a>
                            <a href="http://todayintel.loc/channels/trending?filter=newest" class="menu-item" role="menuitemradio">
                                Newest
                            </a>
                            <a href="http://todayintel.loc/channels/trending?filter=trending" class="menu-item" role="menuitemradio">
                                Trending
                            </a>
                            <a href="http://todayintel.loc/channels/trending?filter=top" class="menu-item" role="menuitemradio">
                                Top
                            </a>
                            <a href="http://todayintel.loc/channels/trending?filter=oldest" class="menu-item" role="menuitemradio">
                                Oldest
                            </a>
                            <a href="http://todayintel.loc/channels/trending?filter=following" class="menu-item" role="menuitemradio">
                                Following
                            </a>
                            <a href="http://todayintel.loc/channels/trending?filter=ignoring" class="menu-item" role="menuitemradio">
                                Ignoring
                            </a>
                            <a href="http://todayintel.loc/channels/trending?filter=trash" class="menu-item" role="menuitemradio">
                                Trash
                            </a>
                        </ui-menu>
                    </ui-popup>
                </div>
            </div>
            <div class="grow"></div>
            <a class="btn text-md index-create-post bg-accent" href="http://todayintel.loc/posts/create?channel_id=3">
                Create a Post
            </a>
        </div>
    </form>
</x-waterhole::cp>
