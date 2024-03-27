<?php

namespace App\Data\DTO;
use Spatie\LaravelData\Data;
use stdClass;

class ArticleDTO extends Data
{
    public function __construct(
     readonly public ?string $title,
     readonly public ?string $link,
     readonly public ?string $text,
     readonly public ?string $html,
     readonly public ?string $markdown,
     readonly public ?string $spacy,
     readonly public ?string $spacy_markdown,
     readonly public ?array $keywords,
     readonly public ?array $images,
     readonly public ?array $entities,
     readonly public ?array $sentiment
    ){}

}
