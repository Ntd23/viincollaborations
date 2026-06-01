<?php

// English description: Validates admin package purchase USD to VND exchange rate settings.

namespace Botble\PackagePurchase\Http\Requests;

use Botble\Base\Rules\OnOffRule;
use Botble\Support\Http\Requests\Request;

class SettingsRequest extends Request
{
    public function rules(): array
    {
        return [
            'package_purchase_usd_to_vnd_exchange_rate' => ['required', 'numeric', 'min:1'],
            'package_purchase_whatsapp_enabled' => [new OnOffRule()],
            'package_purchase_whatsapp_access_token' => ['nullable', 'string', 'max:500'],
            'package_purchase_whatsapp_phone_number_id' => ['nullable', 'string', 'max:120'],
            'package_purchase_whatsapp_template_name' => ['nullable', 'string', 'max:120'],
            'package_purchase_whatsapp_template_language' => ['nullable', 'string', 'max:20'],
            'package_purchase_whatsapp_graph_api_version' => ['nullable', 'string', 'max:20'],
            'ref_lang' => ['nullable', 'string'],
        ];
    }
}
