<?php

// English description: Handles admin package purchase exchange rate and WhatsApp notification settings pages.

namespace Botble\PackagePurchase\Http\Controllers;

use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Base\Supports\Breadcrumb;
use Botble\PackagePurchase\Forms\SettingsForm;
use Botble\PackagePurchase\Http\Requests\SettingsRequest;
use Botble\Setting\Http\Controllers\SettingController;
use Illuminate\Http\Request;

class SettingsController extends SettingController
{
    protected function breadcrumb(): Breadcrumb
    {
        return parent::breadcrumb()
            ->add(trans('plugins/package-purchase::package-purchase.name'));
    }

    public function edit(Request $request)
    {
        $this->pageTitle(trans('plugins/package-purchase::package-purchase.settings.title'));

        return SettingsForm::create()->renderForm();
    }

    public function update(SettingsRequest $request): BaseHttpResponse
    {
        $data = $request->validated();

        return $this->performUpdate([
            package_purchase_setting_key('usd_to_vnd_exchange_rate') => $data['package_purchase_usd_to_vnd_exchange_rate'],
            package_purchase_setting_key('whatsapp_enabled') => $request->boolean('package_purchase_whatsapp_enabled'),
            package_purchase_setting_key('whatsapp_access_token') => $data['package_purchase_whatsapp_access_token'] ?? null,
            package_purchase_setting_key('whatsapp_phone_number_id') => $data['package_purchase_whatsapp_phone_number_id'] ?? null,
            package_purchase_setting_key('whatsapp_template_name') => $data['package_purchase_whatsapp_template_name'] ?? null,
            package_purchase_setting_key('whatsapp_template_language') => $data['package_purchase_whatsapp_template_language'] ?? 'en_US',
            package_purchase_setting_key('whatsapp_graph_api_version') => $data['package_purchase_whatsapp_graph_api_version'] ?? 'v21.0',
        ]);
    }
}
