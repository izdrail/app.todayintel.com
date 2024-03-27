<x-waterhole::cp :title="__('waterhole::cp.dashboard-title')">




    <div class="container section measure">

        <form method="POST" action="{{ route('waterhole.cp.article.store') }}">
            @csrf

            <!-- Title !-->
            <x-waterhole::field name="title">
                <label for="title">Title</label>
                <input
                        name="title"
                        type="text"
                        value="{{ old('title', $article->title ?? '') }}"
                        data-action="similar-posts#input"
                >
            </x-waterhole::field>

            <!-- Url !-->
            <x-waterhole::field name="lin">
                <label for="title">Link</label>
                <input
                    name="link"
                    type="url"
                    value="{{ old('link', base64_decode($url) ?? '') }}"
                    data-action="similar-posts#input"
                >
            </x-waterhole::field>

            <!--- Body !-->
            <div style="margin-top:2vh">
                <x-waterhole::field id="post-body" name="body">
                    <label for="title">Body</label>
                    <x-waterhole::text-editor
                            name="body"
                            :id="1"
                            :value="old('body', $article->markdown ?? '')"
                            style="min-height: 50vh"
                    />
                </x-waterhole::field>
            </div>


            <!-- Keywords !-->
            <div style="margin-top:2vh">
                <label for="title">
                    Keywords
                </label>
                @foreach($article->keywords as $keyword)
                    <x-waterhole::field name="keywords">

                        <input
                                name="keywords[]"
                                type="checkbox"
                                value="{{ $keyword }}"
                                checked
                        >
                        {{ $keyword }}
                    </x-waterhole::field>
                @endforeach
            </div>


            <!-- Channel !-->
            <div style="margin-top:2vh">
                <x-waterhole::field id="post-channel" name="channel">
                    <label for="title">
                        Channels
                    </label>
                    <select name="channel_id">
                        <option value="">Please select a channel</option>
                        @foreach($channels as $channel)
                            <option value="{{ $channel->id }}">
                                {{ $channel->name }}
                            </option>
                        @endforeach
                    </select>
                </x-waterhole::field>
            </div>



            <!-- Images !-->
            <div style="margin-top:2vh">
                <x-waterhole::field id="post-images" name="images">
                    @foreach($article->images as $image)
                        <input
                            name="images[]"
                            type="checkbox"
                            value="{{ $image }}"
                        >
                      <img src="{{ $image }}" alt="image" style="width: 100px; height: 100px">
                    @endforeach
                </x-waterhole::field>
            </div>

            <!--- Submit !-->
            <div style="margin-top:2vh">
                <button type="submit" class="btn btn-primary">
                   Save
                </button>
            </div>

        </form>
        <div id="chat"></div>
    </div>

</x-waterhole::cp>
