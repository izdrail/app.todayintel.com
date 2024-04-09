<?php
declare(strict_types=1);
namespace App\Data\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;


class Post extends \Waterhole\Models\Post
{

    protected $table = 'posts';

    protected $fillable = [
        'article_id',
        'type',
        'content',
        'scheduled_at',
        'is_published',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
    ];


    final public function article(): BelongsTo
    {
        return $this->belongsTo(Article::class, 'article_id');
    }
}
