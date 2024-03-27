<?php
declare(strict_types=1);
namespace SaturnPHP\Feeds\Jobs;

use SaturnPHP\Feeds\DTO\ArticleDto;
use SaturnPHP\Feeds\Models\Feed;
use SaturnPHP\Feeds\Repositories\Contracts\ArticleRepositoryInterface;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use League\HTMLToMarkdown\HtmlConverter;


class SaveArticle implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    private ArticleDto $article;
    private Feed $feed;
    private string $source;

    public function __construct(ArticleDto $article, Feed $feed, string $source)
    {
        $this->article = $article;
        $this->feed = $feed;
        $this->source = $source;
    }

    /**
     * @todo create a ArticleDTO
     * @throws \JsonException
     */
    final public function handle(ArticleRepositoryInterface $articleRepository): void
    {

        if (str_word_count($this->article->spacy) < 100)  {
            info("Article {$this->article->title} is too short to be saved");
            return;
        }

        $settings = \config('feeds.article-formatting' ?? []);

        $converter = new HtmlConverter($settings);


        try {

            $postData = [
                'feed_id' => $this->feed->id,
                'source' => $this->source,
                'title' => $this->article->title,
                'date' => $this->article->date,
                'text' => $this->article->text,
                'html' => $this->article->html,
                'markdown' => $converter->convert($this->article->html),
                'banner' => $this->article->banner,
                'summary' => $this->article->summary,
                'authors' => json_encode($this->article->authors, JSON_THROW_ON_ERROR),
                'keywords' => json_encode($this->article->keywords, JSON_THROW_ON_ERROR),
                'images' => json_encode($this->article->images, JSON_THROW_ON_ERROR),
                'entities' => json_encode($this->article->entities, JSON_THROW_ON_ERROR),
                'social' => json_encode($this->article->social, JSON_THROW_ON_ERROR),
                'sentiment' => json_encode($this->article->sentiment, JSON_THROW_ON_ERROR),
                'spacy' => $this->article->spacy,
            ];

            $articleRepository->create($postData);

        } catch (\Exception $exception) {
            info("Something went wrong trying to save the {$this->source} }");
            info($exception->getTraceAsString());
            info($exception->getMessage());
            info($exception->getLine());
        }
    }
}
