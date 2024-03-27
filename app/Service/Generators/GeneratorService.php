<?php
declare(strict_types=1);

namespace App\Service\Generators;

use App\Agents\BaseAgent;
use App\Contracts\GeneratorContract;
use App\Data\DTO\Services\AIResponseDTO;
use App\Data\Models\Post;
use App\Saloon\Requests\Cloudflare\CloudflareRequest;
use JsonException;
use RuntimeException;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Connector;


readonly class GeneratorService implements GeneratorContract
{
    public function __construct(private Connector $connector)
    {

    }

    /**
     * @throws FatalRequestException
     * @throws RequestException
     * @throws JsonException
     */
    final public function generate(BaseAgent $baseAgent): AIResponseDTO
    {
        //todo check here because connector can be abstract
        $response = $this->connector->send(new CloudflareRequest($baseAgent));

        if ($response->status() !== 200) {
            throw new RuntimeException(
                sprintf('Failed to generate content. Status: %s. Response Body %s',
                    $response->status(),
                    $response->body()
                )
            );
        }

        $content = json_decode($response->body(), true, 512, JSON_THROW_ON_ERROR);

        $aiResponseDTO = AIResponseDTO::from([
            'response' => $content['result']['response'],
            'agent' => $baseAgent->getInstructions(),
            'context' => $baseAgent->getContext()->toArray()
        ]);

        //todo use repository to store content
        Post::updateOrCreate(
            [
                'article_id' => $baseAgent->getContext()->id,
                'type' => get_class($baseAgent),
            ],
            [
                'content' => $aiResponseDTO->response,
                'is_published' => false,
                'scheduled_at' => now()->addHours(),
            ]
        );

        return $aiResponseDTO;
    }
}
