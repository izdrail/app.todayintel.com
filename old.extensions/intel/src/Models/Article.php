<?php

namespace SaturnPHP\Intel\Models;

/**
 * Class Article
 * @package Cornatul\Intel\Models
 * @property int $id
 * @property int $link_id
 * @property string $title
 * @property string $text
 * @property string $html
 * @property string $markdown
 * @property string $spacy
 * @property string $spacy_markdown
 * @property array $keywords
 * @property array $images
 * @property array $entities
 * @property \Carbon\Carbon $created_at
 * @property \Carbon\Carbon $updated_at
 * @method create(array $array)
 */
class Article extends \Illuminate\Database\Eloquent\Model
{

        protected $fillable = [
            'title',
            'link',
            'text',
            'html',
            'markdown',
            'spacy',
            'spacy_markdown',
            'keywords',
            'images',
            'entities',
        ];


        public function link(): \Illuminate\Database\Eloquent\Relations\BelongsTo
        {
            return $this->belongsTo(intel\src\Models\Link::class);
        }
}
