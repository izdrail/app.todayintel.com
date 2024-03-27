<?php

return [
    'extract' => env('INTEL_EXTRACT', 'https://api.todayintel.com/nlp/article'),
    'trends' => env('INTEL_TRENDS', 'https://api.todayintel.com/google/trending'),
    'news' => env('INTEL_NEWS', 'https://api.todayintel.com/google/news/search'),
    'topic' => env('INTEL_NEWS_TOPIC', 'https://api.todayintel.com/google/news/topic'),
];