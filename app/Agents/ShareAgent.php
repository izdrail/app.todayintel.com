<?php
declare(strict_types=1);
namespace App\Agents;

use App\Contracts\AgentContract;
use App\Contracts\Social\ShareContract;
use App\DTO\SocialAccountDTO;
use App\Models\SocialAccount;
use App\Models\SocialPost;

/**
 * Class ShareAgent
 * @package App\Agents
 */
class ShareAgent implements ShareContract
{
    private array $agents = [
        'facebook' => 'Facebook',
        'twitter' => 'Twitter',
        'linkedin' => 'LinkedIn',
        'instagram' => 'Instagram',

    ];

    public function __construct(private readonly AgentContract $agent)
    {
    }

    public function share(SocialPost $post, SocialAccount $account): void
    {

    }
}
