<?php

// English description: Handles frontend checkout for service packages.

namespace Botble\PackagePurchase\Http\Controllers;

use Botble\Base\Enums\BaseStatusEnum;
use Botble\Base\Http\Controllers\BaseController;
use Botble\PackagePurchase\Enums\OrderStatusEnum;
use Botble\PackagePurchase\Enums\PaymentStatusEnum;
use Botble\PackagePurchase\Models\Order;
use Botble\Portfolio\Models\Package;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CheckoutController extends BaseController
{
    public function selectConsultationLanguage(Package $package, string $consultationLanguage): RedirectResponse
    {
        abort_if(! in_array($consultationLanguage, array_keys(package_purchase_consultation_languages()), true), 404);

        return $this->createOrderAndRedirect($package, $consultationLanguage);
    }

    public function show(Package $package, Request $request): RedirectResponse
    {
        $data = $request->validate([
            'consultation_language' => ['required', Rule::in(array_keys(package_purchase_consultation_languages()))],
        ]);

        return $this->createOrderAndRedirect($package, $data['consultation_language']);
    }

    public function store(Package $package, Request $request): RedirectResponse
    {
        $data = $request->validate([
            'consultation_language' => ['required', Rule::in(array_keys(package_purchase_consultation_languages()))],
        ]);

        return $this->createOrderAndRedirect($package, $data['consultation_language']);
    }

    protected function createOrderAndRedirect(Package $package, string $consultationLanguage): RedirectResponse
    {
        abort_if($package->status->getValue() !== BaseStatusEnum::PUBLISHED, 404);

        $this->createOrFindPendingOrder($package, $consultationLanguage);

        return redirect()
            ->route('public.package-purchase.account', ['tab' => 'orders'])
            ->with('success', trans('plugins/package-purchase::package-purchase.account.order_created'));
    }

    protected function createOrFindPendingOrder(Package $package, string $consultationLanguage): Order
    {
        $amount = package_purchase_parse_price($package->price);
        $currency = package_purchase_display_currency();
        $exchangeRate = package_purchase_usd_to_vnd_exchange_rate();
        $paymentAmount = package_purchase_convert_usd_to_vnd($amount, $exchangeRate);
        $paymentCurrency = package_purchase_payment_currency();
        $isFree = $amount <= 0;
        $paymentMethod = defined('SEPAY_PAYMENT_METHOD_NAME') ? SEPAY_PAYMENT_METHOD_NAME : 'sepay';

        $existingOrder = Order::query()
            ->where('customer_id', auth('package-customer')->id())
            ->where('package_id', $package->getKey())
            ->where('consultation_language', $consultationLanguage)
            ->where('status', OrderStatusEnum::PENDING)
            ->where('payment_status', PaymentStatusEnum::UNPAID)
            ->first();

        if ($existingOrder) {
            $existingOrder->forceFill([
                'package_name' => $package->name,
                'package_price' => $package->price,
                'duration' => $package->duration->getValue(),
                'amount' => $amount,
                'currency' => $currency['code'],
                'payment_amount' => $isFree ? 0 : $paymentAmount,
                'payment_currency' => $paymentCurrency['code'],
                'exchange_rate' => $exchangeRate,
                'status' => $isFree ? OrderStatusEnum::COMPLETED : OrderStatusEnum::PENDING,
                'payment_status' => $isFree ? PaymentStatusEnum::PAID : PaymentStatusEnum::UNPAID,
                'payment_method' => $paymentMethod,
                'payment_reference' => $existingOrder->payment_reference ?: package_purchase_order_code($existingOrder->getKey()),
                'paid_at' => $isFree ? now() : null,
            ])->save();

            return $existingOrder;
        }

        $order = Order::query()->create([
            'customer_id' => auth('package-customer')->id(),
            'package_id' => $package->getKey(),
            'package_name' => $package->name,
            'package_price' => $package->price,
            'duration' => $package->duration->getValue(),
            'consultation_language' => $consultationLanguage,
            'amount' => $amount,
            'currency' => $currency['code'],
            'payment_amount' => $isFree ? 0 : $paymentAmount,
            'payment_currency' => $paymentCurrency['code'],
            'exchange_rate' => $exchangeRate,
            'status' => $isFree ? OrderStatusEnum::COMPLETED : OrderStatusEnum::PENDING,
            'payment_status' => $isFree ? PaymentStatusEnum::PAID : PaymentStatusEnum::UNPAID,
            'payment_method' => $paymentMethod,
            'paid_at' => $isFree ? now() : null,
        ]);

        $order->update(['payment_reference' => package_purchase_order_code($order->getKey())]);

        return $order;
    }
}
