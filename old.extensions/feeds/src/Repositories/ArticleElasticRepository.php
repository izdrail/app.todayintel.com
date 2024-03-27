<?php
declare(strict_types=1);
namespace SaturnPHP\Feeds\Repositories;



use SaturnPHP\Feeds\DTO\ArticleDto;
use SaturnPHP\Feeds\Models\Article;
use SaturnPHP\Feeds\Repositories\Contracts\ArticleRepositoryInterface;
use SaturnPHP\Feeds\Repositories\Contracts\SortableInterface;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
class ArticleElasticRepository implements ArticleRepositoryInterface
{
    public final function create(array $articleDto): bool
    {
        $id =  Article::create($articleDto);
        return (bool)$id;
    }

    public final function destroy(int $id): int
    {
        return Article::destroy($id);
    }

    public final function getArticlesByFeedId(int $feedId, int $limit = 10): LengthAwarePaginator
    {
        return Article::where('feed_id', $feedId)->limit($limit)->paginate();
    }

    public final function getArticleById(int $articleId): Article
    {
        return Article::where('id', $articleId)->first();
    }


    public final function update(int $id, array $data): int
    {
        return Article::where('id', $id)->update($data);
    }

    public final function getAllArticles(int $limit = 10): LengthAwarePaginator
    {
        return Article::with('feed')
            ->orderByRaw("JSON_EXTRACT(sentiment, '$.pos') DESC")
            ->limit($limit)->paginate();
    }

}
