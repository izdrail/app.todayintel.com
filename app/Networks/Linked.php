<?php
declare(strict_types=1);
namespace App\Networks;

use JsonException;
use GuzzleHttp\RequestOptions;
use Laravel\Socialite\Two\LinkedInProvider;
use Laravel\Socialite\Two\User;

class Linked extends LinkedInProvider
{
    public $scopes = ["profile","w_member_social", "openid", "email"];

    private string $projections = '(sub,name,picture,given_name,family_name,email,locale,email_verified)';

    /**
     *
     * @throws JsonException
     */
    protected function getUserByToken($token):array
    {
        return $this->getBasicProfile($token);
    }

    protected function getBasicProfile($token): array
    {
        $response = $this->getHttpClient()->get('https://api.linkedin.com/v2/userinfo', [
            RequestOptions::HEADERS => [
                'Authorization' => 'Bearer '.$token,
                'X-RestLi-Protocol-Version' => '2.0.0',
            ],
            RequestOptions::QUERY => [
                'projection' => $this->projections,
            ],
        ]);

        return (array) json_decode($response->getBody(), true, 512, JSON_THROW_ON_ERROR);
    }

    /**
     * {@inheritdoc}
     */
    final protected function mapUserToObject(array $user):User
    {

        return (new User)->setRaw($user)->map([
            'id' => $user['sub'] ?? "",
            'name' => $user['name'] ?? "",
            'last_name' => $user['given_name'] ?? "",
            'email' => $user['email'] ?? "",
            'avatar' => $user['picture'] ?? "",
        ]);
    }

}
