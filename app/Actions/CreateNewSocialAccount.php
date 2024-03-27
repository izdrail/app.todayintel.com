<?php

namespace App\Actions;

use Illuminate\Foundation\Http\FormRequest;

final class CreateNewSocialAccount extends FormRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|string',
            'user_id' => 'required|int',
        ];
    }

    public function authorize(): bool
    {
        return true;
    }

}
