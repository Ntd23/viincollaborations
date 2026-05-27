<?php

// English description: Handles admin management of package customer accounts.

namespace Botble\PackagePurchase\Http\Controllers;

use Botble\Base\Facades\PageTitle;
use Botble\Base\Http\Actions\DeleteResourceAction;
use Botble\Base\Http\Controllers\BaseController;
use Botble\Base\Http\Responses\BaseHttpResponse;
use Botble\PackagePurchase\Forms\CustomerForm;
use Botble\PackagePurchase\Http\Requests\CustomerRequest;
use Botble\PackagePurchase\Models\Customer;
use Botble\PackagePurchase\Tables\CustomerTable;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class CustomerController extends BaseController
{
    public function index(CustomerTable $table): View|JsonResponse
    {
        PageTitle::setTitle(trans('plugins/package-purchase::package-purchase.customers'));

        return $table->renderTable();
    }

    public function edit(Customer $customer): string
    {
        PageTitle::setTitle(trans('core/base::forms.edit_item', ['name' => $customer->name]));

        return CustomerForm::createFromModel($customer)->renderForm();
    }

    public function update(Customer $customer, CustomerRequest $request): BaseHttpResponse
    {
        CustomerForm::createFromModel($customer)->setRequest($request)->save();

        return $this
            ->httpResponse()
            ->setPreviousUrl(route('package-purchase.customers.index'))
            ->setNextUrl(route('package-purchase.customers.edit', $customer))
            ->setMessage(trans('core/base::notices.update_success_message'));
    }

    public function destroy(Customer $customer): DeleteResourceAction
    {
        return DeleteResourceAction::make($customer);
    }
}
