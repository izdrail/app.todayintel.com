<?php

namespace SaturnPHP\Intel\Http\Requests;

use SaturnPHP\Intel\DTO\ArticleDto;
use SaturnPHP\Intel\DTO\PostDto;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * Class CreatePostRequest
 * @package Cornatul\Intel\Http\Requests
 * @property string $title
 * @property string $body
 * @property int $channel_id
 * @property string $url
 */
class CreatePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    final public function rules(): array
    {
        return [
            'title' => 'required|string',
            'link' => 'required|string',
            'body' => 'required|string',
            'keywords' => 'required|array',
            'images' => 'array',
            'channel_id' => 'required|integer',
        ];
    }


    /**
     * @return intel\src\DTO\PostDto
     */
    final public function getDto(): PostDto
    {
        return PostDto::from([
            'title' => $this->get('title'),
            'link' => $this->get('link'),
            'body' => $this->get('body'),
            'keywords' => $this->get('keywords'),
            'images' => $this->get('images'),
            'channel_id' => $this->get('channel_id'),
        ]);
    }
}
