<?php
declare(strict_types=1);
namespace App\Networks;

use Laravel\Socialite\Two\GithubProvider;

class Github extends GithubProvider
{
    protected $scopes = ['user:email', 'gist'];
}

