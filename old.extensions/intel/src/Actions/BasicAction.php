<?php

namespace SaturnPHP\Intel\Actions;

use GuzzleHttp\Client;

interface  BasicAction
{
    public function execute(Client $client, array $data);
}
