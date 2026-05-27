<?php

// English description: Defines customer account statuses for package purchasing.

namespace Botble\PackagePurchase\Enums;

use Botble\Base\Facades\Html;
use Botble\Base\Supports\Enum;
use Illuminate\Support\HtmlString;

/**
 * @method static CustomerStatusEnum ACTIVATED()
 * @method static CustomerStatusEnum BLOCKED()
 */
class CustomerStatusEnum extends Enum
{
    public const ACTIVATED = 'activated';

    public const BLOCKED = 'blocked';

    public static $langPath = 'plugins/package-purchase::package-purchase.statuses';

    public function toHtml(): HtmlString|string
    {
        return match ($this->value) {
            self::ACTIVATED => Html::tag('span', $this->label(), ['class' => 'badge bg-success text-success-fg']),
            self::BLOCKED => Html::tag('span', $this->label(), ['class' => 'badge bg-danger text-danger-fg']),
            default => parent::toHtml(),
        };
    }
}
