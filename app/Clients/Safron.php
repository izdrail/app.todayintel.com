<?php

namespace App\Clients;

use Saloon\Http\Connector;
use Saloon\Traits\Plugins\HasTimeout;

final class Safron extends Connector
{

    public function __construct()
    {
        //
    }

    public function resolveBaseUrl(): string
    {
        return 'https://safron.io/api/';
    }

    final function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

}

