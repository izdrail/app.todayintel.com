<?php

namespace App\Data\DTO;


use App\DTO\Request;
use Spatie\LaravelData\Data;

/**
 * @method static self fromRequest(Request $request)
 */
class SocialAccountDTO extends Data
{
    public ?string $access_token;
}
