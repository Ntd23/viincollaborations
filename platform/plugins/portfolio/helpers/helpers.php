<?php

if (! function_exists('get_payment_setting_key')) {
    function get_payment_setting_key(string $key, string $methodId): string
    {
        return 'payment_' . $methodId . '_' . $key;
    }
}

if (! function_exists('get_payment_setting')) {
    function get_payment_setting(string $key, string $methodId, $default = null)
    {
        return setting(get_payment_setting_key($key, $methodId), $default);
    }
}

if (! function_exists('get_all_currencies')) {
    function get_all_currencies()
    {
        return collect([
            (object) [
                'title' => 'VND',
                'exchange_rate' => 1,
            ]
        ]);
    }
}
