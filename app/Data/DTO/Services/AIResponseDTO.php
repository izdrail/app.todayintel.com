<?php

namespace App\Data\DTO\Services;

use Spatie\LaravelData\Data;

class AIResponseDTO  extends Data
{
    public string $response;

    public function __construct(string $response)
    {
        $this->response = $response;
    }
}
