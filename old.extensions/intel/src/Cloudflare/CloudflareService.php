<?php

namespace  SaturnPHP\Intel\Cloudflare;


use Illuminate\Support\Collection;

class CloudflareService implements CloudflareInterface
{
    private string $token = 'eYqjpljg9R8SpepLCEtJMyqeSsU5DrMCwvMEjmFd';

    private string $url = 'https://api.cloudflare.com/client/v4/accounts/e2fa0631e7c2fafc79e68a70a5968569/ai/run/@cf/meta/llama-2-7b-chat-int8';

    public function __construct(protected readonly ClientInterface $client)
    {
    }

    final public function rewriteText(string $context): Collection
    {
        $response = $this->client->post($this->url, [
            'headers' => $this->buildHeaders(),
            'json' => $this->buildBody($context)
        ]);

        $content = json_decode($response->getBody()->getContents(), true);

        return collect($content);
    }


    /** This can be moved to a configuration class
     * @return string[]
     */
    private function buildHeaders(): array
    {
        return [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $this->token,
        ];
    }

    private function buildBody(string $userContext): array
    {
        return [
            'messages' => [
                [
                    'role' => 'system',
                    'content' => 'You are an article writer who gets some information and creates a more professional version of the content',
                ],
                [
                    'role' => 'user',
                    'content' => $userContext,
                ],
            ]
        ];
    }
}
