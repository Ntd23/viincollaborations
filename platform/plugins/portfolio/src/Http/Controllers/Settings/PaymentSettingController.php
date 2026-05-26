<?php

namespace Botble\Portfolio\Http\Controllers\Settings;

use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Base\Supports\Breadcrumb;
use Botble\Portfolio\Forms\Settings\PaymentSettingForm;
use Botble\Portfolio\Http\Requests\Settings\PaymentSettingRequest;
use Botble\Setting\Http\Controllers\SettingController;
use Illuminate\Support\Facades\Log;
use Exception;

class PaymentSettingController extends SettingController
{
    protected function breadcrumb(): Breadcrumb
    {
        return parent::breadcrumb()
            ->add('Portfolio', route('portfolio.packages.index'))
            ->add('Cấu hình Thanh toán');
    }

    public function edit()
    {
        $this->pageTitle('Cấu hình Thanh toán');

        return PaymentSettingForm::create()->renderForm();
    }

    public function update(PaymentSettingRequest $request): BaseHttpResponse
    {
        $data = $request->except(['_token', 'submit']);
        
        $response = $this->performUpdate($data);

        // Gọi action hook của Botble Core để các cổng thanh toán tự động xử lý (như đồng bộ ngân hàng, webhook...)
        do_action('core_after_update_settings', $data);
        
        return $response;
    }
}
