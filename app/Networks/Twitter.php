<?php
declare(strict_types=1);
namespace App\Networks;

use Laravel\Socialite\Two\TwitterProvider;

//this needs to be an agent
class Twitter extends TwitterProvider
{
    protected $scopes = ['users.read', 'tweet.read', "tweet.write"];
}
