<?php
declare(strict_types=1);

namespace App\Agents;


use App\Data\Models\Article;

//@todo base agent context interface
class BaseAgent
{

    public string $instructions = "Create a paragraph about provided keyword with provided_keywords hashtags at the end of paragraph. Maximum 250 words.
    Creativity is 0.6 between 0 and 1. Language is english. Tone of voice must be warm.";

    public Article $context;

    final function getInstructions(int $length = 250, string $tone = "positive"): string
    {
        $replace = [
            "{hashtags}" => $this->context->keywords,
            "{maximum_length}" => $length,
            "{creativity}" => 0.4,
            "sentiment" => $this->context->sentiment,
            "{language}" => "english",
            "{tone_of_voice}" => $tone,
        ];

        return strtr($this->instructions, $replace);

    }

    //todo replace with an context object
    final function getContext(): Article
    {
        return $this->context;
    }

    final function getSentiment(): string
    {
        $data =  $this->getContext()->sentiment;

        if ($data['neg'] > $data['pos'])
        {
            return "negative";
        }

        return "positive";
    }

    final function setContext(Article $article): static
    {
        $this->context = $article;
        return $this;
    }
}
