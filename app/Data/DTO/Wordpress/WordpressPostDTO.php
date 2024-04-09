<?php
declare(strict_types=1);

namespace App\Data\DTO\Wordpress;

use Spatie\LaravelData\Data;

class WordpressPostDTO extends Data
{

    public string $title;

    public string $status ="publish";


    public string $content;


    public string $excerpt = '';


    public array $categories;


    public array $tags;


    public array $meta;

}
