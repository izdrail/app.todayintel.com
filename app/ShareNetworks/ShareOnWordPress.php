<?php
declare(strict_types=1);

namespace App\ShareNetworks;

use App\Contracts\Social\ShareContract;
use App\Data\DTO\AccountDTO;
use App\Data\Models\Post;
use RuntimeException;

readonly class ShareOnWordPress implements ShareContract
{

    /**
     */
    final public function share(Post $post, AccountDTO $accountDTO): string
    {
        throw new RuntimeException('ShareOnWordPress is not implemented');
    }
}
