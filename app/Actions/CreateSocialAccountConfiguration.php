<?php

namespace App\Actions;

use Illuminate\Foundation\Http\FormRequest;

final class CreateSocialAccountConfiguration extends FormRequest
{
    public function rules(): array
    {
        return [
            'account' => 'required|int',
            'type' => 'required|string',
            'client_id' => 'required|string',
            'client_secret' => 'required|string',
            'redirect' => 'required|string',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

}
