<?php

namespace Cornatul\Websites\Http\Requests;

class CreateWebsiteRequest extends Request
{

    public function rules(): array
    {
        return [
            'domain' => 'required|string',
            'username' => 'required|string',
            'password' => 'required|string',
        ];
    }
}