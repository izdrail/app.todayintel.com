<?php
declare(strict_types=1);

namespace App\Data\Repositories;

use App\Data\DTO\UserInformationDTO;
use App\Data\Models\SocialAccount;
use Illuminate\Support\Str;
use Random\RandomException;


final class AccountRepository
{

    /**
     * @throws RandomException
     */
    final function updateOrCreate(UserInformationDTO $userInformationDTO): SocialAccount
    {
        return SocialAccount::updateOrCreate(
            [
                'provider_id' => $userInformationDTO->provider_id,
                'provider' => $userInformationDTO->provider,
            ],
            [
                'name' => $userInformationDTO->name,
                'username' => Str::snake($userInformationDTO->name ?? "" . random_bytes(16)),
                'access_token' => $userInformationDTO->access_token,
                'data' => $userInformationDTO->data,
            ]
        );
    }
}
