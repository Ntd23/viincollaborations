<?php

// English description: Represents a frontend customer account for buying service packages.

namespace Botble\PackagePurchase\Models;

use Botble\Base\Casts\SafeContent;
use Botble\Base\Models\BaseModel;
use Botble\PackagePurchase\Enums\CustomerStatusEnum;
use Illuminate\Auth\Authenticatable;
use Illuminate\Contracts\Auth\Authenticatable as AuthenticatableContract;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Notifications\Notifiable;

class Customer extends BaseModel implements AuthenticatableContract
{
    use Authenticatable;
    use Notifiable;

    protected $table = 'package_customers';

    protected $fillable = [
        'name',
        'email',
        'phone',
        'password',
        'avatar',
        'dob',
        'status',
        'email_verified_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'name' => SafeContent::class,
        'email' => SafeContent::class,
        'phone' => SafeContent::class,
        'password' => 'hashed',
        'dob' => 'date',
        'status' => CustomerStatusEnum::class,
        'email_verified_at' => 'datetime',
    ];

    public function orders(): HasMany
    {
        return $this->hasMany(Order::class, 'customer_id');
    }

    public function isActivated(): bool
    {
        return $this->status->getValue() === CustomerStatusEnum::ACTIVATED;
    }
}
