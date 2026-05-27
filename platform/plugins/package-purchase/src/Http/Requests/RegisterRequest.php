<?php

// English description: Validates frontend customer registration requests.

namespace Botble\PackagePurchase\Http\Requests;

use Botble\Support\Http\Requests\Request;

class RegisterRequest extends Request
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'email', 'max:191', 'unique:package_customers,email'],
            'phone' => ['nullable', 'string', 'max:30'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
            'agree_terms' => ['accepted'],
        ];
    }
}
