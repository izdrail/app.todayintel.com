<?php
declare(strict_types=1);

namespace App\ShareNetworks;


use App\Contracts\Social\ShareContract;
use App\Data\DTO\AccountDTO;
use App\Data\Models\Post;
use GuzzleHttp\ClientInterface;
use GuzzleHttp\Exception\GuzzleException;
use Illuminate\Support\Str;

class ShareOnGithubProvider extends ShareAgent implements ShareContract
{

    public function __construct(private ClientInterface $client)
    {
    }

    /**
     * @method
     * @throws GuzzleException
     */
    final public function share(Post $post, AccountDTO $accountDTO): string
    {
        $token = $accountDTO->token;

        $content = [
            'description' => 'Read more on https://lzomedia.com - published on ' . now()->format('Y-m-d H:i:s'),
            'public' => true,
            'files' => [
                Str::slug($post->title) . '.md' => [
                    'content' => $post->article->body,
                    "type" =>  "text/markdown",
                     "language" =>  "Markdown",
                ],
            ]
        ];

        $response = $this->client->post('https://api.github.com/gists', [
            'headers' => [
                'Accept' => 'application/vnd.github.v3+json',
                'Authorization' => 'Bearer ' . $token,
            ],
            'json' => $content,
        ]);

        return $response->getBody()->getContents();
    }
}
