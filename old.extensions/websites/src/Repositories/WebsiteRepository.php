<?php

namespace Cornatul\Websites\Repositories;

use Cornatul\Websites\Http\Requests\CreateWebsiteRequest;
use Cornatul\Websites\Models\Website;

class WebsiteRepository implements WebsiteRepositoryInterface
{

    public function create(CreateWebsiteRequest $request): Website
    {
        $website = new Website();
        $website->domain = $request->domain;
        $website->username = $request->username;
        $website->password = $request->password;
        $website->save();
        return $website;
    }
}