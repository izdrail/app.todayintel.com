<?php
declare(strict_types=1);
namespace App\Networks;

use Laravel\Socialite\Two\FacebookProvider;


//this needs to be an agent
class Facebook extends FacebookProvider
{
    protected $scopes = ['email', 'pages_manage_instant_articles', 'instagram_content_publish'];
}
