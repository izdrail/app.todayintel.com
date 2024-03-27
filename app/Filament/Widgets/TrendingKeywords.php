<?php

declare(strict_types=1);

namespace App\Filament\Widgets;

use App\Data\Repositories\KeywordRepository;
use Filament\Widgets\ChartWidget;


class TrendingKeywords extends ChartWidget
{
    protected static ?string $heading = 'Trending keywords';

    protected static ?string $maxWidth = '100%';

    protected static bool $isLazy = true;

    protected static ?array $options = [
        'plugins' => [
            'legend' => [
                'display' => true,
            ],
        ],
    ];

    protected int|string|array $columnSpan = 2;

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getData(): array
    {
        return [
            'datasets' => [
                [
                    'label' => self::$heading,
                    'data' => 1,
                ],
            ],
            'labels' => ( new KeywordRepository())->getLatestKeywords()->take(100)
                ->pluck([
                    'keyword',
                    'count'
                ])
                ->toArray(),
        ];
    }
}
