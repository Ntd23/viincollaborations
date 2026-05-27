<?php

if (! function_exists('get_payment_setting')) {
    function get_payment_setting(string $key, string $name = '', $default = null): mixed
    {
        return setting()->get('payment_' . $name . '_' . $key, $default);
    }
}

if (! function_exists('get_payment_setting_key')) {
    function get_payment_setting_key(string $key, string $name = ''): string
    {
        return 'payment_' . $name . '_' . $key;
    }
}
