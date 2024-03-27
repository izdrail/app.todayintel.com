<?php
declare(strict_types=1);

namespace SaturnPHP\Feeds\Http\Controllers;

use SaturnPHP\Feeds\Contracts\FeedFinderInterface;
use SaturnPHP\Feeds\Repositories\Contracts\ArticleRepositoryInterface;
use SaturnPHP\Wordpress\Interfaces\WordpressRepositoryInterface;
use SaturnPHP\Wordpress\WordpressServiceProvider;
use Illuminate\Contracts\View\View as ViewContract;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ArticlesController extends Controller
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    public function __construct()
    {
        $this->middleware('auth');
    }


    final public function articles(int $feedID, ArticleRepositoryInterface $articleRepository): ViewContract
    {
        $articles = $articleRepository->getArticlesByFeedId($feedID, 20);

        return view('feeds::articles', compact('articles'));
    }


    final public function article(int $articleID, ArticleRepositoryInterface $articleRepository): ViewContract
    {
        $article = $articleRepository->getArticleById($articleID);
        return view('feeds::article', compact('article'));

    }

    final public function update(int $articleID, Request $request, ArticleRepositoryInterface $articleRepository): RedirectResponse
    {
        $this->validate($request, [
            'title' => 'required',
            'markdown' => 'required',
        ]);

        $data = $request->except('_token');

        $articleRepository->update($articleID, $data);

        if (class_exists(WordpressServiceProvider::class)) {
            return \redirect()->route('wordpress.article.publish', ['articleID' => $articleID])
                ->with('success', 'Article updated successfully! Now redirecting you to the publish page.');
        }

        return redirect()->back()->with('success', 'Article updated successfully!');
    }


    final public function publish(int $article_id, Request $request, ArticleRepositoryInterface $articleRepository)
    {
        $article = $articleRepository->getArticleById($article_id);

        return \view('feeds::publish', compact('article'));
    }


    final public function allArticles(ArticleRepositoryInterface $repository): ViewContract
    {

        $articles = $repository->getAllArticles(20);

        return view('feeds::allArticles', compact('articles'));
    }
}
