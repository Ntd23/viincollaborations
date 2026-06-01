<?php

// English description: Sends paid package order notifications through Meta WhatsApp Cloud API templates.

namespace Botble\PackagePurchase\Services;

use Botble\PackagePurchase\Models\Order;
use Illuminate\Support\Facades\Http;
use Throwable;

class WhatsAppNotificationService
{
    public function notifyPaidOrder(Order $order): void
    {
        if (! package_purchase_setting('whatsapp_enabled', false)) {
            $order->update(['whatsapp_notification_status' => 'skipped']);

            return;
        }

        try {
            $this->sendTemplate($order);

            $order->update([
                'whatsapp_notification_status' => 'sent',
                'whatsapp_notified_at' => now(),
                'whatsapp_notification_error' => null,
            ]);
        } catch (Throwable $exception) {
            $order->update([
                'whatsapp_notification_status' => 'failed',
                'whatsapp_notification_error' => mb_substr($exception->getMessage(), 0, 1000),
            ]);
        }
    }

    protected function sendTemplate(Order $order): void
    {
        $accessToken = (string) package_purchase_setting('whatsapp_access_token');
        $phoneNumberId = (string) package_purchase_setting('whatsapp_phone_number_id');
        $templateName = (string) package_purchase_setting('whatsapp_template_name');
        $templateLanguage = (string) package_purchase_setting('whatsapp_template_language', 'en_US');
        $apiVersion = trim((string) package_purchase_setting('whatsapp_graph_api_version', 'v21.0')) ?: 'v21.0';
        $recipient = $this->recipientPhone($order);

        if (! $accessToken || ! $phoneNumberId || ! $templateName || ! $recipient) {
            throw new \RuntimeException('WhatsApp Cloud API settings or package recipient phone are missing.');
        }

        $response = Http::withToken($accessToken)
            ->acceptJson()
            ->asJson()
            ->post("https://graph.facebook.com/{$apiVersion}/{$phoneNumberId}/messages", [
                'messaging_product' => 'whatsapp',
                'to' => package_purchase_normalize_whatsapp_phone($recipient, true),
                'type' => 'template',
                'template' => [
                    'name' => $templateName,
                    'language' => ['code' => $templateLanguage],
                    'components' => [
                        [
                            'type' => 'body',
                            'parameters' => $this->templateParameters($order),
                        ],
                    ],
                ],
            ]);

        if ($response->failed()) {
            throw new \RuntimeException($response->body());
        }
    }

    protected function recipientPhone(Order $order): ?string
    {
        $package = $order->package;

        return $order->consultation_language === 'en'
            ? $package->whatsapp_phone_en
            : $package->whatsapp_phone_vi;
    }

    protected function templateParameters(Order $order): array
    {
        $customer = $order->customer;

        return collect([
            package_purchase_order_code($order->getKey()),
            (string) $order->package_name,
            package_purchase_consultation_language_label($order->consultation_language),
            (string) $customer->name,
            (string) $customer->email,
            (string) $order->customer_whatsapp_phone,
            package_purchase_format_price($order->amount, $order->currency),
            package_purchase_format_price($order->payment_amount, $order->payment_currency),
        ])
            ->map(fn (string $value) => ['type' => 'text', 'text' => $value])
            ->all();
    }
}
