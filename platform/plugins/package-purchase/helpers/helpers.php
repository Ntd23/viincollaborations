<?php

// English description: Provides public helper functions for package purchase routes and USD to VND payment conversion.

use Botble\Portfolio\Models\Package;
use Botble\PackagePurchase\Models\Order;
use Illuminate\Support\Facades\Route;

if (! function_exists('package_purchase_setting_key')) {
    function package_purchase_setting_key(string $key, ?string $locale = null): string
    {
        return "package_purchase_{$key}";
    }
}

if (! function_exists('package_purchase_setting')) {
    function package_purchase_setting(string $key, mixed $default = null, ?string $locale = null): mixed
    {
        return setting(package_purchase_setting_key($key), $default);
    }
}

if (! function_exists('package_purchase_currency')) {
    function package_purchase_currency(?string $currencyCode = null, ?string $locale = null): array
    {
        $code = strtoupper($currencyCode ?: 'USD');
        $defaults = [
            'USD' => ['symbol' => '$', 'position' => 'prefix', 'decimals' => 0],
            'VND' => ['symbol' => "\u{0111}", 'position' => 'suffix', 'decimals' => 0],
        ];
        $currency = $defaults[$code] ?? ['symbol' => $code, 'position' => 'suffix', 'decimals' => 2];

        return [
            'code' => $code,
            'symbol' => $currency['symbol'],
            'position' => $currency['position'],
            'decimals' => $currency['decimals'],
        ];
    }
}

if (! function_exists('package_purchase_display_currency')) {
    function package_purchase_display_currency(): array
    {
        return package_purchase_currency('USD');
    }
}

if (! function_exists('package_purchase_payment_currency')) {
    function package_purchase_payment_currency(): array
    {
        return package_purchase_currency('VND');
    }
}

if (! function_exists('package_purchase_parse_price')) {
    function package_purchase_parse_price(string|int|float|null $price): float
    {
        $normalized = preg_replace('/[^0-9.\-]/', '', (string) $price);

        return $normalized !== '' ? (float) $normalized : 0.0;
    }
}

if (! function_exists('package_purchase_usd_to_vnd_exchange_rate')) {
    function package_purchase_usd_to_vnd_exchange_rate(): float
    {
        $rate = package_purchase_parse_price(package_purchase_setting('usd_to_vnd_exchange_rate', 25000));

        return $rate > 0 ? $rate : 25000.0;
    }
}

if (! function_exists('package_purchase_convert_usd_to_vnd')) {
    function package_purchase_convert_usd_to_vnd(string|int|float|null $usdAmount, ?float $exchangeRate = null): float
    {
        return round(package_purchase_parse_price($usdAmount) * ($exchangeRate ?: package_purchase_usd_to_vnd_exchange_rate()));
    }
}

if (! function_exists('package_purchase_order_code')) {
    function package_purchase_order_code(int|string $orderId): string
    {
        return 'SF-' . str_pad((string) $orderId, 7, '0', STR_PAD_LEFT);
    }
}

if (! function_exists('package_purchase_sepay_bank_info')) {
    function package_purchase_sepay_bank_info(): array
    {
        if (class_exists(\FriendsOfBotble\SePay\Services\BankService::class)) {
            return app(\FriendsOfBotble\SePay\Services\BankService::class)->getBankInfo();
        }

        return [
            'bank' => setting('payment_sepay_bank') ?? 'Vietcombank',
            'bankLogo' => setting('payment_sepay_bank_logo'),
            'bankShortName' => setting('payment_sepay_bank_short_name'),
            'bankBrandName' => setting('payment_sepay_bank_brand_name'),
            'bankAccountNumber' => setting('payment_sepay_bank_account_number'),
            'bankAccountHolder' => setting('payment_sepay_bank_account_holder'),
        ];
    }
}

if (! function_exists('package_purchase_sepay_qr_url')) {
    function package_purchase_sepay_qr_url(Order $order, ?array $bankInfo = null): ?string
    {
        $bankInfo = $bankInfo ?: package_purchase_sepay_bank_info();

        if (empty($bankInfo['bankAccountNumber']) || empty($bankInfo['bankShortName']) || ! $order->payment_reference) {
            return null;
        }

        $amount = package_purchase_parse_price($order->payment_amount);

        if ($amount <= 0) {
            return null;
        }

        if (class_exists(\FriendsOfBotble\SePay\Services\BankService::class)) {
            return app(\FriendsOfBotble\SePay\Services\BankService::class)
                ->getQrCodeUrl($bankInfo['bankAccountNumber'], $bankInfo['bankShortName'], $amount, $order->payment_reference);
        }

        return 'https://qr.sepay.vn/img?' . http_build_query([
            'acc' => $bankInfo['bankAccountNumber'],
            'bank' => $bankInfo['bankShortName'],
            'amount' => $amount,
            'des' => $order->payment_reference,
            'template' => 'compact',
        ]);
    }
}

if (! function_exists('package_purchase_format_price')) {
    function package_purchase_format_price(string|int|float|null $price, ?string $currencyCode = null, ?string $locale = null): string
    {
        $currency = package_purchase_currency($currencyCode, $locale);
        $amount = package_purchase_parse_price($price);
        $formattedAmount = number_format($amount, $currency['decimals']);
        $separator = $currency['code'] === $currency['symbol'] ? ' ' : '';

        if ($currency['position'] === 'prefix') {
            return $currency['symbol'] . $separator . $formattedAmount;
        }

        return $formattedAmount . $separator . $currency['symbol'];
    }
}

if (! function_exists('package_purchase_checkout_url')) {
    function package_purchase_checkout_url(Package $package, ?string $consultationLanguage = null): string
    {
        if (! Route::has('public.package-purchase.consultation-language') && ! Route::has('public.package-purchase.checkout')) {
            return (string) $package->action_url;
        }

        if ($consultationLanguage) {
            if (Route::has('public.package-purchase.consultation-language')) {
                return route('public.package-purchase.consultation-language', [
                    'package' => $package,
                    'consultationLanguage' => $consultationLanguage,
                ]);
            }

            return route('public.package-purchase.checkout', [
                'package' => $package,
                'consultation_language' => $consultationLanguage,
            ]);
        }

        return route('public.package-purchase.checkout', $package);
    }
}

if (! function_exists('package_purchase_consultation_languages')) {
    function package_purchase_consultation_languages(): array
    {
        return [
            'vi' => trans('plugins/package-purchase::package-purchase.consultation_language.vi'),
            'en' => trans('plugins/package-purchase::package-purchase.consultation_language.en'),
        ];
    }
}

if (! function_exists('package_purchase_consultation_language_label')) {
    function package_purchase_consultation_language_label(?string $language): string
    {
        $languages = package_purchase_consultation_languages();

        return $languages[$language] ?? trans('plugins/package-purchase::package-purchase.consultation_language.not_selected');
    }
}
