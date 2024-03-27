<?php
declare(strict_types=1);
namespace SaturnPHP\Feeds\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Article
 * @method static create(array $postData)
 * @method static where(string $column, int $value)
 * @method static destroy(int $id)
 * @method static update(array $data)
 * @method static first()
 * @method static orderBy(string $column, string $direction)
 * @param string $table
 * @package Cornatul\Feeds\Models
 * @property string source
 * @property string title
 * @property string date
 * @property string text
 * @property string html
 * @property string markdown
 * @property string spacy
 * @property string banner
 * @property string $keywords
 *
 */
class Article extends Model
{
    protected $table = 'feeds_article';


    protected $index = 'feeds_article';

    public $fillable = [
        'feed_id',
        'source',
        'title' ,
        'date' ,
        'text',
        'html',
        'markdown',
        'spacy',
        'banner',
        'summary',
        "authors",
        "keywords",
        "images",
        "entities",
        "social",
        "sentiment",
    ];

    protected $casts = [
        'sentiment' => 'json',
        'pos' => 'float',
        'neu' => 'float',
        'neg' => 'float',
        'compound' => 'float',
    ];

    public function feed()
    {
        return $this->belongsTo(Feed::class);
    }
}
