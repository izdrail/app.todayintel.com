<x-waterhole::cp :title="__('waterhole::cp.dashboard-title')">

    <h2 style="margin-bottom:20px">
      View latest news - {{ $keyword }}
    </h2>


    @include('intel::partials.search')

    <table class="full-width" style="width: 100%">
        <thead>
        <tr>
            <th>News</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @foreach($news as $key => $article)
            <tr>
                <td>
                    {{ $article['title'] }}
                    <br>
                    <small>
                        {{ $article['date'] }}
                    </small>
                </td>
                <td>
                    <a href="{{ route('waterhole.cp.article.index',
                           ['url' => base64_encode($article['url'])]) }}"
                       target="_blank"
                       class="btn btn-primary">
                        Get Article
                    </a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

</x-waterhole::cp>