<?php
declare(strict_types=1);
namespace App\Data\Models;

use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use JsonException;

/**
 * * @param string $token
 * * @param string $secret
 * * @param int $social_account_id
 * * @method static create(array $data)
 * * @method static find (int $id)
 * * @method static where (string $column, string $value)
 * * @method static inRandomOrder()
 */
class Network extends Model
{
    protected $table = "social_networks";

    protected $fillable= [
        'application_id',
        'name',
        'configuration',
    ];


    public final function application():BelongsTo
    {
        return $this->belongsTo(Application::class);
    }

    public function accounts(): HasMany
    {
        return $this->hasMany(SocialAccount::class);
    }

    /**
     * @throws JsonException
     */
    public final function getConfigurationAttribute(string | null $value):object|null
    {
        return json_decode($value, null, 512, JSON_THROW_ON_ERROR);
    }

}
