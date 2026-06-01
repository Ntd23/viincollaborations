<?php

// English description: Builds the admin settings form for package purchase payment conversion and WhatsApp notifications.

namespace Botble\PackagePurchase\Forms;

use Botble\Base\Forms\FieldOptions\NumberFieldOption;
use Botble\Base\Forms\FieldOptions\OnOffFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\NumberField;
use Botble\Base\Forms\Fields\OnOffField;
use Botble\Base\Forms\Fields\TextField;
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
            )
            ->add(
                'package_purchase_whatsapp_enabled',
                OnOffField::class,
                OnOffFieldOption::make()
                    ->label(trans('plugins/package-purchase::package-purchase.settings.whatsapp_enabled'))
                    ->value((bool) package_purchase_setting('whatsapp_enabled', false))
                    ->helperText(trans('plugins/package-purchase::package-purchase.settings.whatsapp_enabled_helper'))
            )
            ->add(
                'package_purchase_whatsapp_access_token',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/package-purchase::package-purchase.settings.whatsapp_access_token'))
                    ->value(package_purchase_setting('whatsapp_access_token'))
                    ->helperText(trans('plugins/package-purchase::package-purchase.settings.whatsapp_access_token_helper'))
            )
            ->add(
                'package_purchase_whatsapp_phone_number_id',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/package-purchase::package-purchase.settings.whatsapp_phone_number_id'))
                    ->value(package_purchase_setting('whatsapp_phone_number_id'))
                    ->helperText(trans('plugins/package-purchase::package-purchase.settings.whatsapp_phone_number_id_helper'))
            )
            ->add(
                'package_purchase_whatsapp_template_name',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/package-purchase::package-purchase.settings.whatsapp_template_name'))
                    ->value(package_purchase_setting('whatsapp_template_name'))
                    ->helperText(trans('plugins/package-purchase::package-purchase.settings.whatsapp_template_name_helper'))
            )
            ->add(
                'package_purchase_whatsapp_template_language',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/package-purchase::package-purchase.settings.whatsapp_template_language'))
                    ->value(package_purchase_setting('whatsapp_template_language', 'en_US'))
                    ->helperText(trans('plugins/package-purchase::package-purchase.settings.whatsapp_template_language_helper'))
            )
            ->add(
                'package_purchase_whatsapp_graph_api_version',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/package-purchase::package-purchase.settings.whatsapp_graph_api_version'))
                    ->value(package_purchase_setting('whatsapp_graph_api_version', 'v21.0'))
                    ->helperText(trans('plugins/package-purchase::package-purchase.settings.whatsapp_graph_api_version_helper'))
            );
    }
}
