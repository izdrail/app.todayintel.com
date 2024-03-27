<?php

namespace  SaturnPHP\Intel\Actions;

use GuzzleHttp\Client;

class GenerateQuestions
{

    //todo return response json object
    public function execute(array $data):string
    {

        $url = 'https://api.cloudflare.com/client/v4/accounts/e2fa0631e7c2fafc79e68a70a5968569/ai/run/@cf/meta/llama-2-7b-chat-int8';
        $bearerToken = 'eYqjpljg9R8SpepLCEtJMyqeSsU5DrMCwvMEjmFd';


        $client = new Client();

        $response = $client->post($url, [
            'headers' => [
                'Authorization' => 'Bearer ' . $bearerToken,
                'Content-Type' => 'application/json',
            ],
            'json' => $data,
        ]);

        return $response->getBody()->getContents();
    }
}
