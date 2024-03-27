<?php
declare(strict_types=1);
namespace App\Agents;


use App\Data\Models\Article;

final class BlogAgent extends BaseAgent
{

    public string $instructions = 'You are a article assistant
    that will take a text and generate a blog post in a {sentiment} tone and return just the generated content nothing else';

    public function __construct(public Article $article)
    {

    }
}
