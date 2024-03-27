<?php
declare(strict_types=1);

namespace App\ShareNetworks;

use App\Contracts\Social\ShareContract;
use App\Data\DTO\AccountDTO;
use App\Data\Models\Post;
use Coderjerk\BirdElephant\BirdElephant;
use Coderjerk\BirdElephant\Compose\Media;
use Coderjerk\BirdElephant\Compose\Tweet;
use Illuminate\Support\Str;

readonly class ShareOnTwitterProvider implements ShareContract
{
    /**
     */
    final public function share(Post $post, AccountDTO $accountDTO): void
    {

        $credentials = array(
            'consumer_key' => env('TWITTER_CONSUMER_KEY' ?? ""), // identifies your app, always needed
            'consumer_secret' => env('TWITTER_CONSUMER_SECRET' ?? ""), // app secret, always needed
            'bearer_token' => env('TWITTER_BEARER_TOKEN' ?? ""), // OAuth 2.0 Bearer Token requests
            'auth_token' => env('TWITTER_AUTH_TOKEN') ?? "", // OAuth 2.0 Bearer Token requests
            'token_identifier' => env('TWITTER_ACCESS_TOKEN') ?? '', // OAuth 1.0a User Context requests
            'token_secret' => env('TWITTER_ACCESS_TOKEN_SECRET') ?? '', // OAuth 1.0a User Context requests
        );

        $birdElephant = new BirdElephant($credentials);

        $image = $birdElephant->tweets()->upload($post->banner);

        $media = (new Media)->mediaIds(
            [
                $image->media_id_string
            ]
        );


        $tweet = (new Tweet)->text(Str::limit($post->content, 280))
            ->media($media);

        $response = $birdElephant->tweets()->tweet($tweet);

        dd($response);
    }
}
