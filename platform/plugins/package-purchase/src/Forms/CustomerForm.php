<?php

// English description: Builds the admin form for editing package customer accounts.

namespace Botble\PackagePurchase\Forms;

use Botble\Base\Forms\FieldOptions\EmailFieldOption;
use Botble\Base\Forms\FieldOptions\NameFieldOption;
use Botble\Base\Forms\FieldOptions\PhoneNumberFieldOption;
use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\Fields\EmailField;
use Botble\Base\Forms\Fields\PhoneNumberField;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\PackagePurchase\Enums\CustomerStatusEnum;
use Botble\PackagePurchase\Http\Requests\CustomerRequest;
use Botble\PackagePurchase\Models\Customer;

class CustomerForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(Customer::class)
            ->setValidatorClass(CustomerRequest::class)
            ->columns()
            ->add('name', TextField::class, NameFieldOption::make()->required())
            ->add('email', EmailField::class, EmailFieldOption::make()->required())
            ->add('phone', PhoneNumberField::class, PhoneNumberFieldOption::make())
            ->add(
                'status',
                SelectField::class,
                SelectFieldOption::make()
                    ->required()
                    ->choices(CustomerStatusEnum::labels())
                    ->label(trans('plugins/package-purchase::package-purchase.customer.status'))
            )
            ->setBreakFieldPoint('status');
    }
}
