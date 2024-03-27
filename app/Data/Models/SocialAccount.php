<?php
declare(strict_types=1);
namespace App\Data\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/**
 * Class SocialAccount
 * @package Cornatul\Social\Models
 * @property int $id
 * @property string $provider;
 * @property int $provider_id;
 * @property string access_token;
 * @property Network $configuration
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @method static create(array $data)
 * @method static find(int $id)
 * @method static updateOrCreate(array $columns, array $data = [])
 */
class SocialAccount extends Model
{
    protected $fillable = [
        'name',
        'username',
        'media',
        'provider',
        'provider_id',
        'data',
        'access_token'
    ];

    protected $casts = [
        'data' => 'array',
    ];

    public function posts(): HasMany
    {
        return $this->hasMany(Post::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
