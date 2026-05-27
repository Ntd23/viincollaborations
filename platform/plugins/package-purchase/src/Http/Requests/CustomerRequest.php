<?php

// English description: Validates admin updates to package customer accounts.

namespace Botble\PackagePurchase\Http\Requests;

use Botble\PackagePurchase\Enums\CustomerStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class CustomerRequest extends Request
{
    public function rules(): array
    {
        $customerId = $this->route('customer')?->getKey();

        return [
            'name' => ['required', 'string', 'max:191'],
            'email' => ['required', 'email', 'max:191', Rule::unique('package_customers', 'email')->ignore($customerId)],
            'phone' => ['nullable', 'string', 'max:30'],
            'status' => ['required', Rule::in(CustomerStatusEnum::values())],
        ];
    }
}
