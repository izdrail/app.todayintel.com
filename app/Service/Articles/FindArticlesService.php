<?php

declare(strict_types=1);

namespace App\Service\Articles;

use App\Jobs\Articles\FindArticles;
use Illuminate\Support\Collection;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;

/**
 *
 */
final readonly class FindArticlesService
{

    public function __construct(
        private string $keyword
    )
    {

    }

    /**
     * @throws FatalRequestException
     * @throws RequestException
     * @throws \JsonException
     */
    public function handle(): Collection
    {
        return ((new FindArticles($this->keyword))->handle());
    }
}
