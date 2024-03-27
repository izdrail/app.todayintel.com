<?php
declare(strict_types=1);
namespace SaturnPHP\Intel\DTO;

use Spatie\LaravelData\Data;

/**
 *
 */
class PostDto extends Data
{

    public function __construct(
        readonly public string $title,
        readonly public string $link,
        readonly public string $body,
        readonly public array $keywords,
        readonly public array $images,
        readonly public int $channel_id,
    ){}
}
