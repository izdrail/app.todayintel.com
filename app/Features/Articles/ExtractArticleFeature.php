<?php
declare(strict_types=1);

namespace App\Features\Articles;

use App\Data\DTO\KeywordDTO;
use App\Jobs\Keywords\GetKeywords;
use App\Jobs\Keywords\SaveKeywords;
use Illuminate\Support\Collection;
use Lucid\Units\Feature;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;


final class ExtractArticleFeature extends Feature
{

    /**
     */
    final public function handle():Collection
    {

        return $this->run();
    }
}
