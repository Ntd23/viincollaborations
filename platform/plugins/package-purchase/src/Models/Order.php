<?php

// English description: Represents an order created when a customer buys a service package.

namespace Botble\PackagePurchase\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Models\BaseModel;
use Botble\PackagePurchase\Enums\OrderStatusEnum;
use Botble\PackagePurchase\Enums\PaymentStatusEnum;
use Botble\Portfolio\Models\Package;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends BaseModel
{
    protected $table = 'package_orders';

    protected $fillable = [
        'customer_id',
        'package_id',
        'package_name',
        'package_price',
        'duration',
        'consultation_language',
        'customer_whatsapp_phone',
        'amount',
        'currency',
        'payment_amount',
        'payment_currency',
        'exchange_rate',
        'status',
        'payment_status',
        'payment_method',
        'payment_reference',
        'paid_at',
        'whatsapp_notified_at',
        'whatsapp_notification_status',
        'whatsapp_notification_error',
        'notes',
    ];

    protected $casts = [
        'package_name' => SafeContent::class,
        'package_price' => SafeContent::class,
        'duration' => SafeContent::class,
        'consultation_language' => SafeContent::class,
        'customer_whatsapp_phone' => SafeContent::class,
        'amount' => 'decimal:2',
        'currency' => SafeContent::class,
        'payment_amount' => 'decimal:2',
        'payment_currency' => SafeContent::class,
        'exchange_rate' => 'decimal:4',
        'status' => OrderStatusEnum::class,
        'payment_status' => PaymentStatusEnum::class,
        'payment_method' => SafeContent::class,
        'payment_reference' => SafeContent::class,
        'paid_at' => 'datetime',
        'whatsapp_notified_at' => 'datetime',
        'whatsapp_notification_status' => SafeContent::class,
        'whatsapp_notification_error' => SafeContent::class,
    ];

    public function customer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id')->withDefault();
    }

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class, 'package_id')->withDefault();
    }
}
