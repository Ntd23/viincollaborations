<?php

// English description: Handles admin management of package purchase orders.

namespace Botble\PackagePurchase\Http\Controllers;

use Botble\Base\Facades\PageTitle;
use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\PackagePurchase\Enums\PaymentStatusEnum;
use Botble\PackagePurchase\Forms\OrderForm;
use Botble\PackagePurchase\Http\Requests\OrderRequest;
use Botble\PackagePurchase\Models\Order;
use Botble\PackagePurchase\Tables\OrderTable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class OrderController extends BaseController
{
    public function index(OrderTable $table): View|JsonResponse
    {
        PageTitle::setTitle(trans('plugins/package-purchase::package-purchase.orders'));

        return $table->renderTable();
    }

    public function edit(Order $order): string
    {
        PageTitle::setTitle(trans('core/base::forms.edit_item', ['name' => '#' . $order->getKey()]));

        return OrderForm::createFromModel($order)->renderForm();
    }

    public function update(Order $order, OrderRequest $request): BaseHttpResponse
    {
        $data = $request->validated();

        $markAsPaid = (
            $data['payment_status'] === PaymentStatusEnum::PAID
            && $order->payment_status->getValue() !== PaymentStatusEnum::PAID
        );

        OrderForm::createFromModel($order)->setRequest($request)->save();

        if ($markAsPaid) {
            $order->update(['paid_at' => now()]);
        }

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('package-purchase.orders.index'))
            ->setNextUrl(route('package-purchase.orders.edit', $order))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Order $order): DeleteResourceAction
    {
        return DeleteResourceAction::make($order);
    }
}
