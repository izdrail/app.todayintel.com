<?php

namespace SaturnPHP\Intel\Models;



use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class Link
 * @package Cornatul\Intel\Models
 * @property int $id
 * @property string $link
 * @property Article[] $articles
 * @method static Link create(array $attributes)
 * @method static Link findOrFail(int $id)
 * @method static Link where(string $string, string $url)
 */
class Link extends Model
{

    protected $fillable = [
        'link',
    ];

    protected $casts = [
        'id' => 'integer',
        'link' => 'string',
    ];

    final public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }
}
