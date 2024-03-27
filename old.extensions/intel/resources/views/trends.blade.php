<x-waterhole::cp :title="__('waterhole::cp.dashboard-title')">
   @include('intel::partials.search')
    <p>
        <small>
            We are using Google trends data to find the most popular keywords.
        </small>
    </p>
    <div class="" tabindex="0">
        <table class="full-width" style="width: 100%">
            <thead>
            <tr>
                <th>ID</th>
                <th>Keyword</th>
                <th>News</th>
            </tr>
            </thead>
            <tbody>
            @foreach($keywords as $key => $keyword)
                <tr>
                    <td>{{ $key }}</td>
                    <td>{{ $keyword }}</td>
                    <td>
                        <form method="get" action="{{ route('waterhole.cp.news.index') }}">
                            @csrf
                            <input type="hidden" name="q" value="{{ $keyword }}">
                            <button type="submit" class="btn btn-primary">
                                View News
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

</x-waterhole::cp>