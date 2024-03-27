<?php
declare(strict_types=1);
namespace App\Agents;

use App\Data\Models\Article;
final class LinkedInAgent extends BaseAgent
{
     public string $agent = 'LinkedIn';

    public string $instructions = 'You are a LinkedIn assistant that will take a text and generate a LinkedIn post in a {sentiment} professional tone';

    public function __construct(
        public  Article $article)
    {

    }
}
