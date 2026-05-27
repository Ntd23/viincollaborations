<?php

// English description: Validates frontend customer profile update requests.

namespace Botble\PackagePurchase\Http\Requests;

use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class ProfileRequest extends Request
{
    public function rules(): array
    {
        $customer = auth('package-customer')->user();

        return [
            'name' => ['required', 'string', 'max:191'],
            'dob' => ['nullable', 'date', 'before:today'],
            'email' => ['required', 'email', 'max:191', Rule::unique('package_customers', 'email')->ignore($customer?->getKey())],
            'phone' => ['nullable', 'string', 'max:30'],
        ];
    }
}
