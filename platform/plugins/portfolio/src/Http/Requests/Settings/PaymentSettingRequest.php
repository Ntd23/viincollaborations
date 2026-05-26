<?php

namespace Botble\Portfolio\Http\Requests\Settings;

use Botble\Support\Http\Requests\Request;

class PaymentSettingRequest extends Request
{
    public function rules(): array
    {
        $rules = [];

        $mockRequest = new \Botble\Payment\Http\Requests\PaymentMethodRequest();
        $mockRequest->merge($this->all());

        $rules = apply_filters('core_request_rules', $rules, $mockRequest);

        return $rules;
    }
}
