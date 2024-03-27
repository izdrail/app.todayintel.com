<?php
declare(strict_types=1);
namespace App\Data\Repositories;

use App\Contracts\Social\SocialConfiguration;
use App\Data\DTO\NetworkDTO;
use App\Data\DTO\UserInformationDTO;
use App\Data\Models\Network;
use App\Data\Models\SocialAccount;
use Random\RandomException;

/**
 * todo Check This and create tests
 * @implements SocialConfiguration
 */
final class NetworksRepository implements SocialConfiguration
{

    public function __construct(readonly AccountRepository $accountRepository)
    {

    }

    //get account configuration
    final public function getAccountConfiguration(string $account,string $network): NetworkDTO
    {
        $data = Network::where('name', $network)->first();

        return NetworkDTO::from($data);
    }

    /**
     * @todo remove this an inject account repository in the required place
     * @throws RandomException
     */
    final public function saveAccountInformation(UserInformationDTO $userInformationDTO):SocialAccount
    {
        return $this->accountRepository->updateOrCreate($userInformationDTO);
    }

}
