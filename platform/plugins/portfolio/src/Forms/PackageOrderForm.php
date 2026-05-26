<?php

namespace Botble\Portfolio\Forms;

use Botble\Base\Forms\FieldOptions\SelectFieldOption;
use Botble\Base\Forms\FieldOptions\TextFieldOption;
use Botble\Base\Forms\Fields\SelectField;
use Botble\Base\Forms\Fields\TextField;
use Botble\Base\Forms\FormAbstract;
use Botble\Portfolio\Models\PackageOrder;

class PackageOrderForm extends FormAbstract
{
    public function setup(): void
    {
        $this
            ->model(PackageOrder::class)
            ->columns()
            ->add(
                'payment_code',
                TextField::class,
                TextFieldOption::make()
                    ->label('Mã thanh toán')
                    ->addAttribute('readonly', 'readonly')
            )
            ->add(
                'package_name',
                TextField::class,
                TextFieldOption::make()
                    ->label('Gói dịch vụ')
                    ->addAttribute('readonly', 'readonly')
            )
            ->add(
                'name',
                TextField::class,
                TextFieldOption::make()
                    ->label('Tên khách hàng')
                    ->addAttribute('readonly', 'readonly')
            )
            ->add(
                'email',
                TextField::class,
                TextFieldOption::make()
                    ->label('Email')
                    ->addAttribute('readonly', 'readonly')
            )
            ->add(
                'phone',
                TextField::class,
                TextFieldOption::make()
                    ->label('Số điện thoại')
                    ->addAttribute('readonly', 'readonly')
            )
            ->add(
                'amount',
                TextField::class,
                TextFieldOption::make()
                    ->label('Số tiền (VND)')
                    ->addAttribute('readonly', 'readonly')
                    ->value($this->getModel()->id ? number_format($this->getModel()->amount) : '0')
            )
            ->add(
                'payment_method',
                TextField::class,
                TextFieldOption::make()
                    ->label('Phương thức thanh toán')
                    ->addAttribute('readonly', 'readonly')
            )
            ->add(
                'status',
                SelectField::class,
                SelectFieldOption::make()
                    ->label('Trạng thái đơn hàng')
                    ->choices([
                        'pending' => 'Chờ thanh toán',
                        'completed' => 'Đã thanh toán',
                        'failed' => 'Thất bại',
                        'cancelled' => 'Đã hủy',
                    ])
            )
            ->setBreakFieldPoint('status');
    }
}
