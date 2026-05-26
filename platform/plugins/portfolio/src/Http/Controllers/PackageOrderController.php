<?php

namespace Botble\Portfolio\Http\Controllers;

use Botble\Base\Facades\PageTitle;
use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\Portfolio\Forms\PackageOrderForm;
use Botble\Portfolio\Models\PackageOrder;
use Botble\Portfolio\Tables\PackageOrderTable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class PackageOrderController extends BaseController
{
    public function index(PackageOrderTable $table): View|JsonResponse
    {
        PageTitle::setTitle('Đơn hàng gói dịch vụ');

        return $table->renderTable();
    }

    public function edit(PackageOrder $packageOrder): string
    {
        PageTitle::setTitle('Chi tiết đơn hàng ' . $packageOrder->payment_code);

        return PackageOrderForm::createFromModel($packageOrder)->renderForm();
    }

    public function update(PackageOrder $packageOrder, Request $request): BaseHttpResponse
    {
        $request->validate([
            'status' => 'required|in:pending,completed,failed,cancelled',
        ]);

        PackageOrderForm::createFromModel($packageOrder)->setRequest($request)->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('portfolio.package-orders.index'))
            ->setNextUrl(route('portfolio.package-orders.edit', $packageOrder))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(PackageOrder $packageOrder): DeleteResourceAction
    {
        return DeleteResourceAction::make($packageOrder);
    }
}
