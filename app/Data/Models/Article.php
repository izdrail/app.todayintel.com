<?php

namespace App\Data\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\Article
 * @property int $id
 * @property string $title
 * @property string $status
 * @property string $body
 * @property string $summary
 * @property array $sentiment
 * @property string $url
 * @method static where(string $string, string $url)
 */
class Article extends Model
{

    const CREATED_AT = 'created_at';

    const UPDATED_AT = 'updated_at';

    const PENDING = 'pending';

    const PROCESSED = 'processed';

    const FAILED = 'failed';

    use HasFactory;

    protected $fillable = ['title', 'status','body', 'summary', 'link' , 'images', 'keywords', 'sentiment'];


    protected $casts = [
        'images' => 'array',
        'keywords' => 'array',
        'sentiment' => 'array',
    ];

    public function post()
    {
        return $this->hasMany(Post::class);
    }


    public function scopeWhereUrl($query, $url)
    {
        return $query->where('link', $url);
    }

    public function scopeWhereStatus($query, $status)
    {
        return $query->where('status', $status);
    }


}
