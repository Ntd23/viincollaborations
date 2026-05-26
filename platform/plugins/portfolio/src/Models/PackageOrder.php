<?php

namespace Botble\Portfolio\Models;

use Botble\Base\Models\BaseModel;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PackageOrder extends BaseModel
{
    protected $table = 'pf_package_orders';

    protected $fillable = [
        'package_id',
        'package_name',
        'package_price',
        'name',
        'email',
        'phone',
        'amount',
        'status',
        'payment_code',
        'payment_method',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
    ];

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class, 'package_id');
    }
}
