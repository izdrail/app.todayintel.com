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
use JsonException;
use Lucid\Units\Controller;
use ReflectionException;
use Saloon\Exceptions\InvalidResponseClassException;
use Saloon\Exceptions\PendingRequestException;
use Saloon\Exceptions\Request\FatalRequestException;
use Saloon\Exceptions\Request\RequestException;


class ApiController extends Controller
{

    /**
     * @throws FatalRequestException
     * @throws RequestException
     * @throws JsonException
     */
    final function search(Request $request): JsonResponse
    {
        $keyword = $request->get('keyword');

        //todo resource
        $articles = new FindArticlesService($keyword);


        return response()->json(['data' => $articles->handle()]);
    }


    /**
     * @throws FatalRequestException
     * @throws RequestException
     * @throws JsonException
     */
    final function trending():JsonResponse
    {

        $keywords = ( new TrendingFeature())->handle()->take(200);

        return response()->json(['data' => $keywords]);
    }


    //

    /**
     * @throws InvalidResponseClassException
     * @throws ReflectionException
     * @throws FatalRequestException
     * @throws PendingRequestException
     * @throws RequestException
     */
    final function extract(Request $request): JsonResponse
    {

        $article = Article::where('link', $request->get('url'))->first();

        if(!$article)
        {
            $articleDTO = ArticleDTO::from([

                'title' => $request->get('title'),
                'link' => $request->get('url'),
                'status' => 'pending'
            ]);

            $repository = new ArticlesRepository();

            $article = $repository->createOrUpdate($articleDTO);
        }


        //check if processed
         if($article->status == 'processed')
         {
             return response()->json([ 'data' => $article]);
         }

        $article = new ExtractArticlesService($article);

        $response = $article->handle();


        return response()->json([ 'data' => $response]);
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
