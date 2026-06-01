<?php

// English description: Renders the admin order table for package purchases.

namespace Botble\PackagePurchase\Tables;

use Botble\PackagePurchase\Models\Order;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\Columns\Column;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\EmailColumn;
use Botble\Table\Columns\EnumColumn;
use Botble\Table\Columns\FormattedColumn;
use Botble\Table\Columns\IdColumn;

class OrderTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Order::class)
            ->addActions([
                EditAction::make()->route('package-purchase.orders.edit'),
                DeleteAction::make()->route('package-purchase.orders.destroy'),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('package-purchase.orders.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                FormattedColumn::make('customer_name')
                    ->title(trans('plugins/package-purchase::package-purchase.order.customer'))
                    ->renderUsing(fn (FormattedColumn $column) => e($column->getValue())),
                EmailColumn::make('customer_email')
                    ->title(trans('plugins/package-purchase::package-purchase.customer.email')),
                Column::make('package_name')
                    ->title(trans('plugins/package-purchase::package-purchase.order.package')),
                FormattedColumn::make('consultation_language')
                    ->title(trans('plugins/package-purchase::package-purchase.order.consultation_language'))
                    ->renderUsing(fn (FormattedColumn $column) => e(package_purchase_consultation_language_label($column->getValue()))),
                Column::make('customer_whatsapp_phone')
                    ->title(trans('plugins/package-purchase::package-purchase.order.customer_whatsapp_phone')),
                FormattedColumn::make('amount')
                    ->title(trans('plugins/package-purchase::package-purchase.order.amount'))
                    ->renderUsing(fn (FormattedColumn $column) => e(package_purchase_format_price($column->getValue(), $column->getItem()->currency))),
                FormattedColumn::make('payment_amount')
                    ->title(trans('plugins/package-purchase::package-purchase.order.payment_amount'))
                    ->renderUsing(fn (FormattedColumn $column) => e(package_purchase_format_price($column->getValue(), $column->getItem()->payment_currency))),
                EnumColumn::make('status')
                    ->title(trans('plugins/package-purchase::package-purchase.order.status')),
                EnumColumn::make('payment_status')
                    ->title(trans('plugins/package-purchase::package-purchase.order.payment_status')),
                CreatedAtColumn::make(),
            ])
            ->queryUsing(function ($query) {
                return $query
                    ->leftJoin('package_customers', 'package_customers.id', '=', 'package_orders.customer_id')
                    ->select([
                        'package_orders.id',
                        'package_orders.package_name',
                        'package_orders.consultation_language',
                        'package_orders.customer_whatsapp_phone',
                        'package_orders.amount',
                        'package_orders.currency',
                        'package_orders.payment_amount',
                        'package_orders.payment_currency',
                        'package_orders.status',
                        'package_orders.payment_status',
                        'package_orders.created_at',
                        'package_customers.name as customer_name',
                        'package_customers.email as customer_email',
                    ]);
            });
    }
}
