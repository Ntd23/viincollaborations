<?php

namespace Botble\Portfolio\Forms\Settings;

use Botble\Base\Forms\FieldOptions\HtmlFieldOption;
use Botble\Base\Forms\FieldOptions\OnOffFieldOption;
use Botble\Base\Forms\Fields\HtmlField;
use Botble\Base\Forms\Fields\OnOffCheckboxField;
use Botble\Portfolio\Http\Requests\Settings\PaymentSettingRequest;
use Botble\Portfolio\Supports\PortfolioPayment;
use Botble\Setting\Forms\SettingForm;

class PaymentSettingForm extends SettingForm
{
    public function setup(): void
    {
        parent::setup();

        $this
            ->setSectionTitle('Cấu hình Thanh toán')
            ->setSectionDescription('Quản lý và kích hoạt các phương thức thanh toán cho gói dịch vụ Portfolio.')
            ->setValidatorClass(PaymentSettingRequest::class);

        $settingsHtml = apply_filters(PAYMENT_METHODS_SETTINGS_PAGE, '');

        if (empty($settingsHtml)) {
            $this->add(
                'no_methods_warning',
                HtmlField::class,
                HtmlFieldOption::make()
                    ->content('<div class="alert alert-warning">Chưa có phương thức thanh toán nào được đăng ký. Vui lòng cài đặt và kích hoạt plugin cổng thanh toán.</div>')
            );
            return;
        }

        $this->add(
            'payment_methods_settings',
            HtmlField::class,
            HtmlFieldOption::make()
                ->content('<div class="payment-methods-settings-container">' . $settingsHtml . '</div>')
        );
    }
}
