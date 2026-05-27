<?php

namespace Botble\Payment\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static void method(string $id, array $options = [])
 * @method static array getMethods()
 * @method static array getActiveMethods()
 * 
 * @see \Botble\Payment\Supports\PaymentMethods
 */
class PaymentMethods extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \Botble\Payment\Supports\PaymentMethods::class;
    }
}
