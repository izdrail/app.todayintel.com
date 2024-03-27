<?php

namespace Cornatul\Websites\Repositories;

use Cornatul\Websites\Http\Requests\CreateWebsiteRequest;
use Cornatul\Websites\Models\Website;

interface WebsiteRepositoryInterface
{

    public function create(CreateWebsiteRequest $request): Website;

}