<?php
declare(strict_types=1);
namespace App\Contracts;




use App\DTO\MessageDTO;
use App\DTO\SocialAccountDTO;
use App\DTO\UserInformationDTO;

interface AgentContract
{
    public function handle();
}
