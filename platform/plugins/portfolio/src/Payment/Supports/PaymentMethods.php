<?php

namespace Botble\Payment\Supports;

class PaymentMethods
{
    protected array $methods = [];

    public function method(string $id, array $options = []): void
    {
        $this->methods[$id] = $options;
    }

    public function getMethods(): array
    {
        return $this->methods;
    }

    public function getActiveMethods(): array
    {
        return array_filter($this->methods, function ($method, $id) {
            return (bool) get_payment_setting('status', $id, false);
        }, ARRAY_FILTER_USE_BOTH);
    }
}
