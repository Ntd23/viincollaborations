<?php

// English description: Adds VND payment snapshots for USD package purchase orders.

use Botble\PackagePurchase\Enums\OrderStatusEnum;
use Botble\PackagePurchase\Enums\PaymentStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::table('package_orders', function (Blueprint $table): void {
            if (! Schema::hasColumn('package_orders', 'payment_amount')) {
                $table->decimal('payment_amount', 15, 2)->default(0)->after('currency');
            }

            if (! Schema::hasColumn('package_orders', 'payment_currency')) {
                $table->string('payment_currency', 10)->default('VND')->after('payment_amount');
            }

            if (! Schema::hasColumn('package_orders', 'exchange_rate')) {
                $table->decimal('exchange_rate', 15, 4)->default(25000)->after('payment_currency');
            }
        });

        $exchangeRate = $this->exchangeRate();

        DB::table('package_orders')
            ->where('status', OrderStatusEnum::PENDING)
            ->where('payment_status', PaymentStatusEnum::UNPAID)
            ->update([
                'currency' => 'USD',
                'payment_amount' => DB::raw(sprintf('ROUND(amount * %F)', $exchangeRate)),
                'payment_currency' => 'VND',
                'exchange_rate' => $exchangeRate,
                'payment_method' => 'sepay',
                'updated_at' => now(),
            ]);
    }

    public function down(): void
    {
        Schema::table('package_orders', function (Blueprint $table): void {
            if (Schema::hasColumn('package_orders', 'exchange_rate')) {
                $table->dropColumn('exchange_rate');
            }

            if (Schema::hasColumn('package_orders', 'payment_currency')) {
                $table->dropColumn('payment_currency');
            }

            if (Schema::hasColumn('package_orders', 'payment_amount')) {
                $table->dropColumn('payment_amount');
            }
        });
    }

    protected function exchangeRate(): float
    {
        $value = DB::table('settings')
            ->where('key', 'package_purchase_usd_to_vnd_exchange_rate')
            ->value('value');

        return is_numeric($value) && (float) $value > 0 ? (float) $value : 25000.0;
    }
};
