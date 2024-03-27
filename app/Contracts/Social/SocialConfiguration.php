<?php
declare(strict_types=1);
namespace App\Contracts\Social;



use App\Data\DTO\NetworkDTO;
use App\Data\DTO\UserInformationDTO;
use App\Data\Models\SocialAccount;

/**
 *
 *
 */
interface SocialConfiguration
{
    public function getAccountConfiguration(string $account, string $network): NetworkDTO;

    public function saveAccountInformation(UserInformationDTO $userInformationDTO): SocialAccount;

}
