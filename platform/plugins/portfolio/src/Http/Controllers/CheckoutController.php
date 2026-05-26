<?php

namespace Botble\Portfolio\Http\Controllers;

use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Portfolio\Models\Package;
use Botble\Portfolio\Models\PackageOrder;
use Botble\Portfolio\Supports\PortfolioPayment;
use Botble\Theme\Facades\Theme;
use Illuminate\Http\Request;

class CheckoutController extends BaseController
{
    public function checkoutForm(Package $package)
    {
        Theme::breadcrumb()->add(__('Checkout'), route('portfolio.package.checkout', $package->id));

        $paymentMethodsHtml = apply_filters(PAYMENT_FILTER_ADDITIONAL_PAYMENT_METHODS, '', [
            'amount' => (float) preg_replace('/[^0-9]/', '', $package->price),
            'currency' => 'VND',
        ]);

        return Theme::scope('portfolio.checkout', compact('package', 'paymentMethodsHtml'))->render();
    }

    public function postCheckout(Request $request, BaseHttpResponse $response)
    {
        $activeMethods = \Botble\Payment\Facades\PaymentMethods::getMethods();
        $allowedMethods = array_keys($activeMethods);

        $request->validate([
            'package_id' => 'required|exists:pf_packages,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'payment_method' => 'required|string|in:' . implode(',', $allowedMethods),
        ]);

        $package = Package::query()->findOrFail($request->input('package_id'));
        $amount = (float) preg_replace('/[^0-9]/', '', $package->price);

        // Tạo đơn hàng ở trạng thái pending
        $order = PackageOrder::query()->create([
            'package_id' => $package->id,
            'package_name' => $package->name,
            'package_price' => $package->price,
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'phone' => $request->input('phone'),
            'amount' => $amount,
            'status' => 'pending',
            'payment_code' => '', // Sẽ cập nhật sau khi có ID
            'payment_method' => $request->input('payment_method'),
        ]);

        // Tạo mã thanh toán duy nhất
        $paymentCode = 'VIIN' . $order->id;
        $order->update(['payment_code' => $paymentCode]);

        // Tạo bản ghi Payment tương ứng phục vụ Webhook
        \Botble\Payment\Models\Payment::query()->create([
            'amount' => $amount,
            'currency' => 'VND',
            'status' => \Botble\Payment\Enums\PaymentStatusEnum::PENDING,
            'charge_id' => $paymentCode,
            'payment_channel' => $request->input('payment_method'),
            'order_id' => $order->id,
        ]);

        return $response
            ->setNextUrl(route('portfolio.package.checkout.payment', $order->id))
            ->setMessage('Đang chuyển hướng đến trang thanh toán...');
    }

    public function payment(PackageOrder $order)
    {
        // Mock dữ liệu Order/Payment tương thích để truyền vào filter của cổng thanh toán
        $paymentMock = (object) [
            'payment_channel' => $order->payment_method,
            'status' => \Botble\Payment\Enums\PaymentStatusEnum::PENDING,
            'currency' => 'VND',
            'charge_id' => $order->payment_code,
        ];

        $orderMock = (object) [
            'amount' => $order->amount,
            'payment' => $paymentMock,
        ];

        $ordersCollection = collect([$orderMock]);

        $paymentInfoHtml = apply_filters('ecommerce_thank_you_customer_info', '', $ordersCollection);

        Theme::breadcrumb()->add(__('Thanh toán'), route('portfolio.package.checkout.payment', $order->id));

        return Theme::scope('portfolio.payment', compact('order', 'paymentInfoHtml'))->render();
    }

    public function checkStatus(PackageOrder $order)
    {
        return response()->json([
            'status' => $order->status,
        ]);
    }

    public function success(PackageOrder $order)
    {
        if ($order->status !== 'completed') {
            return redirect()->route('portfolio.package.checkout.payment', $order->id);
        }

        Theme::breadcrumb()->add(__('Thành công'), route('portfolio.package.checkout.success', $order->id));

        return Theme::scope('portfolio.success', compact('order'))->render();
    }
}
