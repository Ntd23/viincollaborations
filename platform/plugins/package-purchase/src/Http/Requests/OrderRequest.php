<?php

// English description: Validates admin updates to package purchase orders.

namespace Botble\PackagePurchase\Http\Requests;

use Botble\PackagePurchase\Enums\OrderStatusEnum;
use Botble\PackagePurchase\Enums\PaymentStatusEnum;
use Botble\Support\Http\Requests\Request;
use Illuminate\Validation\Rule;

class OrderRequest extends Request
{
    public function rules(): array
    {
        return [
            'status' => ['required', Rule::in(OrderStatusEnum::values())],
            'payment_status' => ['required', Rule::in(PaymentStatusEnum::values())],
            'payment_method' => ['nullable', 'string', 'max:120'],
            'payment_reference' => ['nullable', 'string', 'max:191'],
            'notes' => ['nullable', 'string', 'max:1000'],
        ];
    }
}
