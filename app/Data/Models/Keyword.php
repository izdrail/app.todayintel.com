<?php
declare(strict_types=1);
namespace App\Data\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Keyword
 *
 * @package App\Data\Models

 */
class Keyword extends Model
{
    protected  $fillable = [
        'keyword',
        'count',
        'sentiment',
        'appeared_at',
    ];

    protected $casts = [
        'sentiment' => 'json',
    ];

    final public function articles(): HasMany
    {
        return $this->hasMany(Article::class);
    }
}
