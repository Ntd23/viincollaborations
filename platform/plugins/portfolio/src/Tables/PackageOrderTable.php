<?php

namespace Botble\Portfolio\Tables;

use Botble\Portfolio\Models\PackageOrder;
use Botble\Table\Abstracts\TableAbstract;
use Botble\Table\Actions\DeleteAction;
use Botble\Table\Actions\EditAction;
use Botble\Table\BulkActions\DeleteBulkAction;
use Botble\Table\Columns\Column;
use Botble\Table\Columns\CreatedAtColumn;
use Botble\Table\Columns\IdColumn;
use Botble\Table\Columns\StatusColumn;

class PackageOrderTable extends TableAbstract
{
    public function setup(): void
    {
        $this
            ->model(PackageOrder::class)
            ->addActions([
                EditAction::make()->route('portfolio.package-orders.edit'),
                DeleteAction::make()->route('portfolio.package-orders.destroy'),
            ])
            ->addBulkActions([
                DeleteBulkAction::make()->permission('portfolio.package-orders.destroy'),
            ])
            ->addColumns([
                IdColumn::make(),
                Column::make('payment_code')
                    ->title('Mã thanh toán')
                    ->alignStart()
                    ->route('portfolio.package-orders.edit'),
                Column::make('package_name')
                    ->title('Gói dịch vụ')
                    ->alignStart(),
                Column::make('name')
                    ->title('Khách hàng')
                    ->alignStart(),
                Column::make('email')
                    ->title('Email')
                    ->alignStart(),
                Column::make('phone')
                    ->title('Điện thoại')
                    ->alignStart(),
                Column::make('amount')
                    ->title('Số tiền')
                    ->width(120)
                    ->type('number')
                    ->getValueUsing(fn ($item) => number_format($item->amount) . ' VND'),
                StatusColumn::make('status')
                    ->title('Trạng thái')
                    ->width(100),
                CreatedAtColumn::make(),
            ])
            ->queryUsing(function ($query) {
                return $query
                    ->select([
                        'id',
                        'payment_code',
                        'package_name',
                        'name',
                        'email',
                        'phone',
                        'amount',
                        'status',
                        'created_at',
                    ]);
            });
    }
}
