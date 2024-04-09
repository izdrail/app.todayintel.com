<?php
declare(strict_types=1);

namespace App\Data\DTO;

use Spatie\LaravelData\Data;

class KeywordDTO extends Data
{
    public string $keyword;

    public int $count;

    public array $sentiment;

    public string $appeared_at;
}
