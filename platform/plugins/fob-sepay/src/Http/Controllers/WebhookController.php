<?php

// English description: Handles SePay webhooks for core payments and package purchase orders.

namespace FriendsOfBotble\SePay\Http\Controllers;

use Botble\Base\Events\AdminNotificationEvent;
use Botble\Base\Supports\AdminNotificationItem;
use Botble\PackagePurchase\Enums\OrderStatusEnum as PackageOrderStatusEnum;
use Botble\PackagePurchase\Enums\PaymentStatusEnum as PackagePaymentStatusEnum;
use Botble\PackagePurchase\Models\Order as PackageOrder;
use Botble\PackagePurchase\Services\WhatsAppNotificationService;
use Botble\Payment\Enums\PaymentStatusEnum;
use FriendsOfBotble\SePay\Http\Requests\WebhookRequest;
use Illuminate\Http\JsonResponse;

class WebhookController
{
    public function __invoke(WebhookRequest $request): JsonResponse
    {
        do_action('payment_before_making_api_request', SEPAY_PAYMENT_METHOD_NAME, []);

        $content = $request->input('content', '');
        $transferAmount = (float) $request->input('transferAmount');

        $payment = $this->findCorePayment($content);

        if (! $payment) {
            return $this->handlePackageOrder($request, $content, $transferAmount);
        }

        $expectedAmount = $payment->amount;

        if ($payment->currency !== 'VND') {
            $vndCurrency = get_all_currencies()->firstWhere('title', 'VND');

            if ($vndCurrency) {
                $expectedAmount = round($payment->amount * $vndCurrency->exchange_rate);
            }
        }

        $tolerance = 1000;

        if ($transferAmount < ($expectedAmount - $tolerance)) {
            return response()->json([
                'success' => false,
                'message' => 'insufficient amount.',
            ], 400);
        }

        if ($payment->status == PaymentStatusEnum::COMPLETED) {
            return response()->json(['success' => true]);
        }

        $payment->update([
            'status' => PaymentStatusEnum::COMPLETED,
            'metadata' => $request->input(),
        ]);

        do_action(PAYMENT_ACTION_PAYMENT_PROCESSED, [
            'charge_id' => $payment->charge_id,
            'order_id' => $payment->order_id,
            'customer_id' => $payment->customer_id,
            'customer_type' => $payment->customer_type,
            'payment_channel' => $payment->payment_channel?->getValue(),
            'status' => PaymentStatusEnum::COMPLETED,
            'amount' => $payment->amount,
        ], $request);

        do_action('payment_after_api_response', SEPAY_PAYMENT_METHOD_NAME, [], $request->all());

        return response()->json(['success' => true]);
    }

    protected function findCorePayment(string $content)
    {
        $paymentClass = 'Botble\\Payment\\Models\\Payment';

        if (! class_exists($paymentClass)) {
            return null;
        }

        return $paymentClass::query()
            ->where('payment_channel', SEPAY_PAYMENT_METHOD_NAME)
            ->where(function ($query) use ($content) {
                $query->whereRaw('? LIKE CONCAT("%", charge_id, "%")', [$content])
                    ->orWhere('charge_id', $content);
            })
            ->first();
    }

    protected function handlePackageOrder(WebhookRequest $request, string $content, float $transferAmount): JsonResponse
    {
        $order = PackageOrder::query()
            ->where('payment_method', SEPAY_PAYMENT_METHOD_NAME)
            ->whereNotNull('payment_reference')
            ->where(function ($query) use ($content) {
                $query->whereRaw('? LIKE CONCAT("%", payment_reference, "%")', [$content])
                    ->orWhere('payment_reference', $content);
            })
            ->first();

        if (! $order) {
            return response()->json([
                'success' => false,
                'message' => 'payment not found.',
            ], 400);
        }

        if ($order->payment_status->getValue() === PackagePaymentStatusEnum::PAID) {
            return response()->json(['success' => true]);
        }

        if (
            $order->status->getValue() !== PackageOrderStatusEnum::PENDING
            || $order->payment_status->getValue() !== PackagePaymentStatusEnum::UNPAID
        ) {
            return response()->json([
                'success' => false,
                'message' => 'order is not payable.',
            ], 400);
        }

        $tolerance = 1000;
        $expectedAmount = (float) $order->payment_amount;

        if ($transferAmount < ($expectedAmount - $tolerance)) {
            return response()->json([
                'success' => false,
                'message' => 'insufficient amount.',
            ], 400);
        }

        $order->update([
            'status' => PackageOrderStatusEnum::PROCESSING,
            'payment_status' => PackagePaymentStatusEnum::PAID,
            'paid_at' => now(),
            'notes' => $this->appendWebhookNote($order->notes, $request->all()),
        ]);

        event(new AdminNotificationEvent(
            AdminNotificationItem::make()
                ->title('Package order paid')
                ->description(sprintf('Order %s has been paid via SePay.', package_purchase_order_code($order->getKey())))
                ->action('View order', route('package-purchase.orders.edit', $order))
                ->permission('package-purchase.orders.edit')
        ));

        app(WhatsAppNotificationService::class)->notifyPaidOrder($order->refresh());

        return response()->json(['success' => true]);
    }

    protected function appendWebhookNote(?string $notes, array $payload): string
    {
        $webhookNote = 'SePay webhook: ' . json_encode($payload, JSON_UNESCAPED_UNICODE);

        return trim(($notes ? $notes . PHP_EOL : '') . mb_substr($webhookNote, 0, 2000));
    }
}
