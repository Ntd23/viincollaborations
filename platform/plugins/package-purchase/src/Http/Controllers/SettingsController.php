<?php

// English description: Handles admin package purchase exchange rate settings pages.

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
        ]);
    }
}
