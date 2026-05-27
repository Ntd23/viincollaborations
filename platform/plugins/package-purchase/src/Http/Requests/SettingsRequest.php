<?php

// English description: Validates admin package purchase USD to VND exchange rate settings.

namespace Botble\PackagePurchase\Http\Requests;

use Botble\Support\Http\Requests\Request;
class SettingsRequest extends Request
{
    public function rules(): array
    {
        return [
            'package_purchase_usd_to_vnd_exchange_rate' => ['required', 'numeric', 'min:1'],
            'ref_lang' => ['nullable', 'string'],
        ];
    }
}
