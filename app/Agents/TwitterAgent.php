<?php
declare(strict_types=1);
namespace App\Agents;


use App\Data\Models\Article;


final class TwitterAgent extends BaseAgent
{
    public string $instructions = 'You are a twitter robot assistant that will take a text and generate a tweet no longer than 280 characters in a {sentiment} professional tone';

    public function __construct(public  Article $article)
    {

    }

}
