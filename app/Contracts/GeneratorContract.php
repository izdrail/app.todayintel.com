<?php
declare(strict_types=1);
namespace App\Contracts;

use App\Agents\BaseAgent;
use App\Data\DTO\Services\AIResponseDTO;


interface GeneratorContract
{
    public function generate(BaseAgent $baseAgent): AIResponseDTO;
}
