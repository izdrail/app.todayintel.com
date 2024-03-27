<?php
declare(strict_types=1);
namespace App\Contracts\Social;

use App\Models\Application;

interface SocialContract
{
    public function createApplication(string $name, int $userId): Application;

    public function getApplication(int $id): Application;

    public function updateApplication(int $id, string $name, int $userId): Application;

    public function destroyApplication(int $id): void;
}
