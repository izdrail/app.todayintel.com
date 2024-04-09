<?php
declare(strict_types=1);
namespace App\Jobs\Articles;

use App\Data\DTO\ArticleDTO;
use App\Saloon\Connectors\TodayIntelConnector;
use App\Saloon\Requests\Today\ExtractArticleRequest;
use App\Data\Models\Article;
use Illuminate\Contracts\Queue\ShouldQueue;
use Lucid\Units\Job;
use Saloon\Exceptions\InvalidResponseClassException;
use Saloon\Exceptions\PendingRequestException;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;

final class ExtractArticleJob extends Job implements ShouldQueue
{
    public int $timeout = 90;

    public function __construct(
        public ArticleDTO $article,
    )
    {

    }

    /**
     * @throws InvalidResponseClassException
     * @throws FatalRequestException
     * @throws \ReflectionException
     * @throws PendingRequestException
     * @throws RequestException
     * @throws \Exception
     */
    final public function handle(): ArticleDTO
    {
        $connector = new TodayIntelConnector();


        $response = $connector->send(new ExtractArticleRequest($this->article->link));

        return $response->dtoOrFail();
    }

}
