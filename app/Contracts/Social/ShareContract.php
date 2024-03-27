<?php
declare(strict_types=1);
namespace App\Contracts\Social;
use App\Data\DTO\AccountDTO;
use App\Data\Models\Post;


interface ShareContract
{
    public function share(Post $post,AccountDTO $accountDTO): string;
}
