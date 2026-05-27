<?php

// English description: Defines lifecycle statuses for package purchase orders.

namespace Botble\PackagePurchase\Enums;

use Botble\Base\Facades\Html;
use Botble\Base\Supports\Enum;
use Illuminate\Support\HtmlString;

/**
 * @method static OrderStatusEnum PENDING()
 * @method static OrderStatusEnum PROCESSING()
 * @method static OrderStatusEnum COMPLETED()
 * @method static OrderStatusEnum CANCELLED()
 */
class OrderStatusEnum extends Enum
{
    public const PENDING = 'pending';

    public const PROCESSING = 'processing';

    public const COMPLETED = 'completed';

    public const CANCELLED = 'cancelled';

    public static $langPath = 'plugins/package-purchase::package-purchase.statuses';

    public function toHtml(): HtmlString|string
    {
        return match ($this->value) {
            self::PENDING => Html::tag('span', $this->label(), ['class' => 'badge bg-warning text-warning-fg']),
            self::PROCESSING => Html::tag('span', $this->label(), ['class' => 'badge bg-info text-info-fg']),
            self::COMPLETED => Html::tag('span', $this->label(), ['class' => 'badge bg-success text-success-fg']),
            self::CANCELLED => Html::tag('span', $this->label(), ['class' => 'badge bg-danger text-danger-fg']),
            default => parent::toHtml(),
        };
    }
}
