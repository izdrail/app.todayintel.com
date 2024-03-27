<x-waterhole::cp :title="__('waterhole::cp.dashboard-title')">

   @include('intel::partials.search')
    <p>
        <small>
            We are using Google News & News Api data to find the most popular topics trending.
        </small>
    </p>
    <div class="" tabindex="0">
        <nav aria-label="example">
            <ul class="tabs" role="list">
                @foreach($topics as $topic)
                    <li class="tab" role="listitem">
                        <a href="{{ route('waterhole.cp.topics.index', ['topic' => $topic]) }}" role="tab" aria-controls="tab-{{ $topic }}" aria-selected="false">
                            {{ $topic }}
                        </a>
                    </li>
                @endforeach
            </ul>
        </nav>
        <div class="tab-panel" id="tab-1" role="tabpanel" aria-labelledby="tab-1">
            <table class="full-width" style="width: 100%">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Keyword</th>
                    <th>News</th>
                </tr>
                </thead>
                <tbody>
                @foreach($news as $key => $article)
                    <tr>
                        <td>{{ $key }}</td>
                        <td>{{ $article['title'] }}</td>
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
        </div>
    </div>

</x-waterhole::cp>