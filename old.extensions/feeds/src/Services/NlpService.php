<?php
declare(strict_types=1);
namespace SaturnPHP\Feeds\Services;

use SaturnPHP\Feeds\Contracts\ArticleManager;
use SaturnPHP\Feeds\DTO\ArticleDto;
use SaturnPHP\Feeds\Repositories\Contracts\SortableInterface;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class NlpService implements ArticleManager
{

    /**
     * @todo fix this by proper injecting something
     * @param Model $model
     * @param Request $request
     * @return mixed
     */
    final public  function extract(string $url): \SaturnPHP\Feeds\DTO\ArticleDto
    {
        return new ArticleDto();
    }

}
