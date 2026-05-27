<?php

// English description: Builds the admin settings form for package purchase USD to VND payment conversion.

namespace Botble\PackagePurchase\Forms;

use Botble\Base\Forms\FieldOptions\NumberFieldOption;
use Botble\Base\Forms\Fields\NumberField;
use Botble\PackagePurchase\Http\Requests\SettingsRequest;
use Botble\Setting\Forms\SettingForm;

class SettingsForm extends SettingForm
{
    public function setup(): void
    {
        parent::setup();

        $this
            ->setUrl(route('package-purchase.settings.update'))
            ->setSectionTitle(trans('plugins/package-purchase::package-purchase.settings.title'))
            ->setSectionDescription(trans('plugins/package-purchase::package-purchase.settings.description'))
            ->setFormOption('id', 'package-purchase-settings')
            ->setValidatorClass(SettingsRequest::class)
            ->setActionButtons(view('plugins/package-purchase::settings.actions', ['form' => 'package-purchase-settings'])->render())
            ->add(
                'package_purchase_usd_to_vnd_exchange_rate',
                NumberField::class,
                NumberFieldOption::make()
                    ->label(trans('plugins/package-purchase::package-purchase.settings.usd_to_vnd_exchange_rate'))
                    ->value(package_purchase_usd_to_vnd_exchange_rate())
                    ->min(1)
                    ->step(1)
                    ->helperText(trans('plugins/package-purchase::package-purchase.settings.usd_to_vnd_exchange_rate_helper'))
            );
    }
}
