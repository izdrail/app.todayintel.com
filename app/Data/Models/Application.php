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
 * @property int $user_id
 * @property string $account
 * @property Network $networks
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @method static create(array $data)
 * @method static find(int $id)
 */
class Application extends Model
{

    protected $table = 'applications';

    public $fillable = [
        'user_id',
        'name',
    ];

    public final function networks(): HasMany
    {
        return $this->hasMany(Network::class);
    }
}
