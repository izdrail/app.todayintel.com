<?php

namespace  SaturnPHP\Intel\Cloudflare;

use Illuminate\Support\Collection;

interface CloudflareInterface
{

    public function rewriteText(string $question): Collection;

}
