<?php

namespace Botble\Payment\Enums;

use Botble\Base\Supports\Enum;

class PaymentMethodEnum extends Enum
{
    public const COD = 'cod';
    public const BANK_TRANSFER = 'bank_transfer';
}
