<?php

namespace App\Saloon\Connectors;

use Saloon\Http\Connector;

final class SafronConnector extends Connector
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

