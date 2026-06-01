{{-- English description: Displays a customer-owned package order detail page. --}}

@php
    $lang = 'plugins/package-purchase::package-purchase.account.';
    $bankInfo = package_purchase_sepay_bank_info();
    $qrCodeUrl = package_purchase_sepay_qr_url($order, $bankInfo);
@endphp

<div class="py-4">
    <a href="{{ route('public.package-purchase.account', ['tab' => 'orders']) }}" class="d-inline-flex align-items-center gap-2 mb-4">
        <x-core::icon name="ti ti-arrow-left" />
        {{ trans($lang . 'back_to_orders') }}
    </a>

    <div class="border rounded-4 bg-white overflow-hidden">
        <div class="p-4 border-bottom">
            <h1 class="h3 mb-2">{{ trans($lang . 'order_code', ['code' => package_purchase_order_code($order->getKey())]) }}</h1>
            <div class="d-flex align-items-center gap-2">
                {!! $order->status->toHtml() !!}
                <span class="text-muted">•</span>
                <span class="text-muted">{{ $order->created_at->translatedFormat('M d, Y') }}</span>
            </div>
        </div>

        <div class="p-4">
            <div class="row g-4">
                <div class="col-md-6">
                    <span class="text-muted text-uppercase small">{{ trans('plugins/package-purchase::package-purchase.order.package') }}</span>
                    <strong class="d-block fs-5">{{ $order->package_name }}</strong>
                    @if ($order->duration)
                        <span class="text-muted">{{ $order->duration }}</span>
                    @endif
                </div>
                <div class="col-md-6">
                    <span class="text-muted text-uppercase small">{{ trans($lang . 'total') }}</span>
                    <strong class="d-block fs-5">{{ package_purchase_format_price($order->amount, $order->currency) }}</strong>
                </div>
                <div class="col-md-6">
                    <span class="text-muted text-uppercase small">{{ trans($lang . 'sepay_payable') }}</span>
                    <strong class="d-block fs-5">{{ package_purchase_format_price($order->payment_amount, $order->payment_currency) }}</strong>
                    <span class="text-muted small">{{ trans($lang . 'exchange_rate', ['rate' => package_purchase_format_price($order->exchange_rate, 'VND')]) }}</span>
                </div>
                <div class="col-md-6">
                    <span class="text-muted text-uppercase small">{{ trans('plugins/package-purchase::package-purchase.order.consultation_language') }}</span>
                    <strong class="d-block fs-5">{{ package_purchase_consultation_language_label($order->consultation_language) }}</strong>
                </div>
                <div class="col-md-6">
                    <span class="text-muted text-uppercase small">{{ trans('plugins/package-purchase::package-purchase.order.customer_whatsapp_phone') }}</span>
                    <strong class="d-block fs-5">{{ $order->customer_whatsapp_phone }}</strong>
                </div>
                <div class="col-md-6">
                    <span class="text-muted text-uppercase small">{{ trans($lang . 'payment_status') }}</span>
                    <div>{!! $order->payment_status->toHtml() !!}</div>
                </div>
                <div class="col-md-6">
                    <span class="text-muted text-uppercase small">{{ trans('plugins/package-purchase::package-purchase.order.payment_method') }}</span>
                    <strong class="d-block">{{ $order->payment_method ?: trans($lang . 'not_selected') }}</strong>
                </div>
                @if ($order->payment_reference)
                    <div class="col-md-6">
                        <span class="text-muted text-uppercase small">{{ trans('plugins/package-purchase::package-purchase.order.payment_reference') }}</span>
                        <strong class="d-block">{{ $order->payment_reference }}</strong>
                    </div>
                @endif
                @if ($order->paid_at)
                    <div class="col-md-6">
                        <span class="text-muted text-uppercase small">{{ trans($lang . 'paid_at') }}</span>
                        <strong class="d-block">{{ $order->paid_at->translatedFormat('d M Y H:i') }}</strong>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <div class="border rounded-4 bg-white overflow-hidden mt-4">
        <div class="p-4 border-bottom">
            <h2 class="h4 mb-1">{{ trans($lang . 'bank_transfer') }}</h2>
            <p class="text-muted mb-0">{{ trans($lang . 'bank_transfer_intro') }}</p>
        </div>

        <div class="p-4">
            @if ($qrCodeUrl)
                <div class="row g-4 align-items-center">
                    <div class="col-md-4">
                        <img src="{{ $qrCodeUrl }}" alt="{{ trans($lang . 'scan_qr') }}" class="img-fluid border rounded-3">
                    </div>
                    <div class="col-md-8">
                        <div class="vstack gap-3">
                            <div>
                                <span class="text-muted text-uppercase small">{{ trans($lang . 'bank_name') }}</span>
                                <strong class="d-block">{{ $bankInfo['bankBrandName'] ?: ($bankInfo['bankShortName'] ?: $bankInfo['bank']) }}</strong>
                            </div>
                            <div>
                                <span class="text-muted text-uppercase small">{{ trans($lang . 'account_holder') }}</span>
                                <strong class="d-block">{{ $bankInfo['bankAccountHolder'] }}</strong>
                            </div>
                            <div>
                                <span class="text-muted text-uppercase small">{{ trans($lang . 'bank_account') }}</span>
                                <strong class="d-block">{{ $bankInfo['bankAccountNumber'] }}</strong>
                            </div>
                            <div>
                                <span class="text-muted text-uppercase small">{{ trans($lang . 'transfer_content') }}</span>
                                <strong class="d-block">{{ $order->payment_reference }}</strong>
                            </div>
                            <div>
                                <span class="text-muted text-uppercase small">{{ trans($lang . 'sepay_payable') }}</span>
                                <strong class="d-block">{{ package_purchase_format_price($order->payment_amount, $order->payment_currency) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <p class="mb-0 text-muted">{{ trans($lang . 'sepay_unconfigured') }}</p>
            @endif
        </div>
    </div>
</div>
