<?php
declare(strict_types=1);
namespace App\Data\DTO;


use Spatie\LaravelData\Data;

class MessageDTO extends Data
{
    public string $body;

    public string $image;

    public string $url;
}
