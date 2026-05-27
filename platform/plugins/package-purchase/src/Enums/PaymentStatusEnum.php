<?php

// English description: Defines payment statuses for package purchase orders.

namespace Botble\PackagePurchase\Enums;

use Botble\Base\Facades\Html;
use Botble\Base\Supports\Enum;
use Illuminate\Support\HtmlString;

/**
 * @method static PaymentStatusEnum UNPAID()
 * @method static PaymentStatusEnum PAID()
 * @method static PaymentStatusEnum FAILED()
 */
class PaymentStatusEnum extends Enum
{
    public const UNPAID = 'unpaid';

    public const PAID = 'paid';

    public const FAILED = 'failed';

    public static $langPath = 'plugins/package-purchase::package-purchase.statuses';

    public function toHtml(): HtmlString|string
    {
        return match ($this->value) {
            self::UNPAID => Html::tag('span', $this->label(), ['class' => 'badge bg-warning text-warning-fg']),
            self::PAID => Html::tag('span', $this->label(), ['class' => 'badge bg-success text-success-fg']),
            self::FAILED => Html::tag('span', $this->label(), ['class' => 'badge bg-danger text-danger-fg']),
            default => parent::toHtml(),
        };
    }
}
