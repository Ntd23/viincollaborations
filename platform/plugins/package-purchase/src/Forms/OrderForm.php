<?php

// English description: Builds the admin form for reviewing and updating package orders.

namespace Botble\PackagePurchase\Forms;

use Botble\Base\Forms\FieldOptions\HtmlFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\FieldOptions\TextareaFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\HtmlField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextareaField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\PackagePurchase\Enums\OrderStatusEnum;
use Botble\PackagePurchase\Enums\PaymentStatusEnum;
use Botble\PackagePurchase\Http\Requests\OrderRequest;
use Botble\PackagePurchase\Models\Order;

class OrderForm extends FormAbstract
{
    public function setup(): void
    {
        $order = $this->getModel();

        $summary = $order->getKey()
            ? view('plugins/package-purchase::orders.summary', compact('order'))->render()
            : '';

        $this
            ->model(Order::class)
            ->setValidatorClass(OrderRequest::class)
            ->columns()
            ->add(
                'summary',
                HtmlField::class,
                HtmlFieldOption::make()
                    ->content($summary)
                    ->colspan(2)
                    ->toArray()
            )
            ->add(
                'status',
                SelectField::class,
                SelectFieldOption::make()
                    ->required()
                    ->choices(OrderStatusEnum::labels())
                    ->label(trans('plugins/package-purchase::package-purchase.order.status'))
            )
            ->add(
                'payment_status',
                SelectField::class,
                SelectFieldOption::make()
                    ->required()
                    ->choices(PaymentStatusEnum::labels())
                    ->label(trans('plugins/package-purchase::package-purchase.order.payment_status'))
            )
            ->add(
                'payment_method',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/package-purchase::package-purchase.order.payment_method'))
            )
            ->add(
                'payment_reference',
                TextField::class,
                TextFieldOption::make()
                    ->label(trans('plugins/package-purchase::package-purchase.order.payment_reference'))
            )
            ->add(
                'notes',
                TextareaField::class,
                TextareaFieldOption::make()
                    ->label(trans('plugins/package-purchase::package-purchase.order.notes'))
                    ->colspan(2)
            )
            ->setBreakFieldPoint('status');
    }
}
