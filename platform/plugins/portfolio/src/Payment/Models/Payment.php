<?php

namespace Botble\Payment\Models;

use Botble\Base\Models\BaseModel;
use Botble\Payment\Enums\PaymentStatusEnum;

class Payment extends BaseModel
{
    protected $table = 'payments';

    protected $fillable = [
        'amount',
        'currency',
        'status',
        'charge_id',
        'payment_channel',
        'order_id',
        'customer_id',
        'customer_type',
        'metadata',
    ];

    protected $casts = [
        'status' => PaymentStatusEnum::class,
        'metadata' => 'json',
    ];
}
