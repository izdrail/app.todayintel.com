<?php

namespace Cornatul\Websites\Models;

/**
 * @property string $domain
 * @property string $username
 * @property string $password
 */
class Website extends Model
{
    protected $table = 'websites';
    protected $fillable = [
        'domain',
        'username',
        'password',
    ];

    protected $hidden = [
        'password',
    ];
}
