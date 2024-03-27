<?php

namespace App\Data\DTO;

use Spatie\LaravelData\Data;

class ContentDTO  extends Data
{
    public function __construct(
        public string $content
    ) {
    }

    public function getContent(): string
    {
        return $this->content;
    }
}
