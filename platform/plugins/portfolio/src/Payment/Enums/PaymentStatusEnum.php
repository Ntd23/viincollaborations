<?php

namespace Botble\Payment\Enums;

use Botble\Base\Supports\Enum;

class PaymentStatusEnum extends Enum
{
    public const PENDING = 'pending';
    public const COMPLETED = 'completed';
    public const FAILED = 'failed';
    public const REFUNDED = 'refunded';
    public const FRAUD = 'fraud';
}
