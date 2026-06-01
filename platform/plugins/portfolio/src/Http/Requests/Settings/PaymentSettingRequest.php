<?php

// English description: Validates portfolio payment settings while tolerating optional payment request classes.

namespace Botble\Portfolio\Http\Requests\Settings;

use Botble\Support\Http\Requests\Request;

class PaymentSettingRequest extends Request
{
    public function rules(): array
    {
        $rules = [];
        $paymentMethodRequestClass = 'Botble\\Payment\\Http\\Requests\\PaymentMethodRequest';

        if (class_exists($paymentMethodRequestClass)) {
            $mockRequest = new $paymentMethodRequestClass();
            $mockRequest->merge($this->all());
        } else {
            $mockRequest = $this;
        }

        $rules = apply_filters('core_request_rules', $rules, $mockRequest);

        return $rules;
    }
}
