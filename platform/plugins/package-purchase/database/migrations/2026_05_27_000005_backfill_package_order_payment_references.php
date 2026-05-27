<?php

// English description: Backfills transfer references for existing package purchase orders.

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class() extends Migration {
    public function up(): void
    {
        DB::table('package_orders')
            ->whereNull('payment_reference')
            ->orderBy('id')
            ->select(['id'])
            ->chunkById(100, function ($orders): void {
                foreach ($orders as $order) {
                    DB::table('package_orders')
                        ->where('id', $order->id)
                        ->update([
                            'payment_reference' => 'SF-' . str_pad((string) $order->id, 7, '0', STR_PAD_LEFT),
                            'updated_at' => now(),
                        ]);
                }
            });
    }

    public function down(): void
    {
        // Existing references are intentionally kept because they may be used in bank transfer records.
    }
};
