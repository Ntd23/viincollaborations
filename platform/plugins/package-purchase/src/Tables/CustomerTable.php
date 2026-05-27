<?php

// English description: Renders the admin customer table for package purchasing.

namespace Botble\PackagePurchase\Tables;

use Botble\PackagePurchase\Models\Customer;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\BulkChanges\NameBulkChange;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\EmailColumn;
use Botble\Table\Columns\EnumColumn;
use Botble\Table\Columns\FormattedColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\NameColumn;
use Botble\Table\Columns\PhoneColumn;

class CustomerTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(Customer::class)
            ->addActions([
                EditAction::make()->route('package-purchase.customers.edit'),
                DeleteAction::make()->route('package-purchase.customers.destroy'),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('package-purchase.customers.destroy'),
            ])
            ->addBulkChanges([
                NameBulkChange::make(),
            ])
            ->addColumns([
                IdColumn::make(),
                NameColumn::make()->route('package-purchase.customers.edit'),
                EmailColumn::make(),
                PhoneColumn::make(),
                FormattedColumn::make('orders_count')
                    ->title(trans('plugins/package-purchase::package-purchase.orders'))
                    ->width(120),
                EnumColumn::make('status')
                    ->title(trans('plugins/package-purchase::package-purchase.customer.status')),
                CreatedAtColumn::make(),
            ])
            ->queryUsing(function ($query) {
                return $query
                    ->withCount('orders')
                    ->select([
                        'id',
                        'name',
                        'email',
                        'phone',
                        'status',
                        'created_at',
                    ]);
            });
    }
}
