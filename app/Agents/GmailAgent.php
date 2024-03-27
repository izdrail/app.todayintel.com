<?php
declare(strict_types=1);
namespace App\Agents;


use RuntimeException;
use App\Data\Models\Article;


final class GmailAgent extends BaseAgent
{

    public string $instructions = 'You are a email assistant
    that will take a text and generate a email post in a {sentiment} tone and return just the generated content nothing else';

    /**
     * @todo check gmail api send email and implement here
     */
    public function __construct(public  Article $article)
    {
        throw new RuntimeException("Not implemented yet");
    }
}
