<?php
declare(strict_types=1);

namespace SaturnPHP\Intel\Http\Controllers;



use SaturnPHP\Intel\Crud\CrudInterface;
use SaturnPHP\Intel\Extractor\ExtractorInterface;
use SaturnPHP\Intel\Http\Requests\CreatePostRequest;
use SaturnPHP\Intel\Repositories\ArticleContract;
use SaturnPHP\Intel\Repositories\LinkContract;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Waterhole\Http\Controllers\Controller;
use Waterhole\Models\Channel;
use Waterhole\Models\Post;
use Waterhole\Models\Tag;

/**
 * Class ArticleController
 */
class ArticleController extends Controller
{

    public function __construct(protected readonly ExtractorInterface $extractor)
    {
        //authorize
    }

    final public function index(string $url): View
    {

        $link = base64_decode($url);

        $article = $this->extractor->getArticle($link);

        $channels = Channel::all();

        return view('intel::article', [
            'url' => $url,
            'channels' => $channels,
            'article' => $article,
        ]);
    }

    /**
     * @param intel\src\Http\Requests\CreatePostRequest $request
     * @return \Illuminate\Http\RedirectResponse
     *@todo Add validation, Add authorization, Add validation for the channel
     */
    final public function store(CreatePostRequest $request): \Illuminate\Http\RedirectResponse
    {
        // Validate the request
        $request->validated();

        // Extract the Data Transfer Object (DTO) from the request
        $dto = $request->getDto();

        // Create the post
        $post = Post::create([
            'title' => $dto->title,
            'body' => $dto->body,
            'channel_id' => $dto->channel_id,
            'user_id' => auth()->id(),
        ]);

        // Check if the post was created successfully
        if ($post === null) {
            throw new \RuntimeException('Error creating post');
        }

        // Process keywords
        foreach ($dto->keywords as $keyword) {
            // Check if the keyword already exists
            $existingKeyword = Tag::where('name', $keyword)->first();

            // Create the keyword if it doesn't exist
            if ($existingKeyword === null) {
                $existingKeyword = Tag::create(['name' => $keyword, 'taxonomy_id' => 1]);
            }

            // Attach the keyword to the post
            $post->tags()->attach($existingKeyword->id);
        }

        // Redirect with success message
        return redirect()->route('waterhole.cp.news.index')
            ->with('success', 'Post created successfully');
    }


    public function submit(Request $request): \Illuminate\Http\RedirectResponse
    {
        $request->validated();
    }
}
