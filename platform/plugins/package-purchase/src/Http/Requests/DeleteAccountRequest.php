<?php

// English description: Validates frontend customer account deletion requests.

namespace Botble\PackagePurchase\Http\Requests;

use Botble\Support\Http\Requests\Request;

class DeleteAccountRequest extends Request
{
    public function rules(): array
    {
        return [
            'current_password' => ['required', 'string'],
        ];
    }
}
