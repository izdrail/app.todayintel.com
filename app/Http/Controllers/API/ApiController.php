<?php
declare(strict_types=1);
namespace App\Http\Controllers\API;


use App\Data\DTO\ArticleDTO;
use App\Data\Models\Article;
use App\Data\Repositories\ArticlesRepository;
use App\Features\Articles\TrendingFeature;
use App\Features\GeneratorFeature;
use App\Service\Articles\ExtractArticlesService;
use App\Service\Articles\FindArticlesService;
use Filament\Notifications\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Lucid\Units\Controller;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;


class ApiController extends Controller
{

    /**
     * @throws FatalRequestException
     * @throws RequestException
     * @throws \JsonException
     */
    final function search(Request $request): JsonResponse
    {
        $keyword = $request->get('keyword');

        //todo resource
        $articles = new FindArticlesService($keyword);


        return response()->json(['data' => $articles->handle()]);
    }


    final function trending():JsonResponse
    {
        $keywords = ( new TrendingFeature())->getKeywords()->take(100);

        return response()->json(['data' => $keywords]);
    }


    //
    final function extract(Request $request): JsonResponse
    {

        $article = Article::where('url', $request->get('url'))->first();

        if(!$article)
        {
            $articleDTO = ArticleDTO::from([

                'title' => $request->get('title'),
                'url' => $request->get('url'),
                'status' => 'pending'
            ]);

            $repository = new ArticlesRepository();

            $article = $repository->createOrUpdate($articleDTO);
        }

        $article = $this->serve(ExtractArticlesService::class, [
            'article' => $article,
        ]);

        return response()->json([ 'data' => $article]);
    }


    final function generate(Article $article): RedirectResponse
    {

        $response =  $this->serve(GeneratorFeature::class, [
            'article' => $article,
        ]);

        $response->handle();

        Notification::make()
            ->title("Content sent to AI for generation")
            ->success()
            ->send();

        return redirect()->back();
    }
}
