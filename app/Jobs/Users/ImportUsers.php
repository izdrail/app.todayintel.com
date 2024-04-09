<?php
declare(strict_types=1);
namespace App\Jobs\Users;

use App\Agents\BlogAgent;
use App\Agents\GithubAgent;
use App\Agents\GmailAgent;
use App\Agents\LinkedInAgent;
use App\Agents\TwitterAgent;
use App\Data\DTO\UserInformationDTO;
use App\Data\Models\Article;
use Illuminate\Contracts\Queue\ShouldQueue;
use Lucid\Units\Job;


final class ImportUsers extends Job implements ShouldQueue
{

    public int $timeout = 90;

    public array $providers = [
        GithubAgent::class,
        LinkedInAgent::class,
        TwitterAgent::class,
        BlogAgent::class,
        GmailAgent::class,
    ];

    public function __construct(
        public readonly UserInformationDTO $userInformationDTO
    )
    {

    }

    final public function handle():void
    {

    }
}
