<?php

declare(strict_types=1);

namespace Tests\Unit;

use App\Agents\BaseAgent;
use App\Contracts\GeneratorContract;
use App\Data\DTO\Services\AIResponseDTO;
use App\Data\Models\Article;
use App\Saloon\Connectors\CloudflareConnector;
use App\Saloon\Requests\Cloudflare\CloudflareRequest;
use App\Service\Generators\GeneratorService;
use PHPUnit\Framework\MockObject\Exception;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;
use Saloon\Http\Faking\MockClient;
use Saloon\Http\Faking\MockResponse;
use Saloon\Http\Response;
use Tests\TestCase;


class GeneratorServiceTest extends TestCase
{
    /**
     * Test generate method with successful response
     *
     * @throws FatalRequestException
     * @throws RequestException
     * @throws Exception
     * @throws \JsonException
     */
    final function testGenerateSuccess(): void
    {

        $this->markTestSkipped('To be fixed');
        $mockDTO= AIResponseDTO::from([
            "response" => "",
        ]);

        $response = json_encode([
            'result' => [
                'response' => ''
            ]
        ]);

        $agentMock = $this->createMock(BaseAgent::class);
        $agentMock->expects($this->once())
             ->method('setContext')
            ->with($this->isInstanceOf(Article::class));

        $agentMock->setContext(new Article());


        $mock = $this->createMock(GeneratorContract::class);
        $mock->expects($this->once())
            ->method('generate')
            ->with($agentMock)
            ->willReturn($mockDTO);


        $mockClient = new MockClient([
            CloudflareRequest::class => MockResponse::make(body:$response),
        ]);

        $connector = new CloudflareConnector();
        $connector->withMockClient($mockClient);

        $service = new GeneratorService($connector);
        $response = $service->generate($agentMock);

        $this->assertInstanceOf(Response::class, $response);

    }


}
