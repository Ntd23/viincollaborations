<?php

// English description: Creates package customer accounts and package order tables.

use Botble\PackagePurchase\Enums\CustomerStatusEnum;
use Botble\PackagePurchase\Enums\OrderStatusEnum;
use Botble\PackagePurchase\Enums\PaymentStatusEnum;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::create('package_customers', function (Blueprint $table): void {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->string('phone', 30)->nullable();
            $table->string('password');
            $table->string('avatar')->nullable();
            $table->string('status', 60)->default(CustomerStatusEnum::ACTIVATED);
            $table->timestamp('email_verified_at')->nullable();
            $table->rememberToken();
            $table->timestamps();
        });

        Schema::create('package_orders', function (Blueprint $table): void {
            $table->id();
            $table->foreignId('customer_id')->constrained('package_customers')->cascadeOnDelete();
            $table->foreignId('package_id')->nullable()->index();
            $table->string('package_name');
            $table->string('package_price')->nullable();
            $table->string('duration', 60)->nullable();
            $table->decimal('amount', 15, 2)->default(0);
            $table->string('currency', 10)->default('USD');
            $table->decimal('payment_amount', 15, 2)->default(0);
            $table->string('payment_currency', 10)->default('VND');
            $table->decimal('exchange_rate', 15, 4)->default(25000);
            $table->string('status', 60)->default(OrderStatusEnum::PENDING);
            $table->string('payment_status', 60)->default(PaymentStatusEnum::UNPAID);
            $table->string('payment_method', 120)->nullable();
            $table->string('payment_reference')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('package_orders');
        Schema::dropIfExists('package_customers');
    }
};
