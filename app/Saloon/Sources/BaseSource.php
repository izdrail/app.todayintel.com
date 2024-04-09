<?php

namespace App\Saloon\Sources;

use App\Contracts\SourceContract;

class BaseSource implements SourceContract
{
    public function getSource():string
    {
        return "";
    }
}
