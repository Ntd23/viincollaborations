<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class () extends Migration {
    public function up(): void
    {
        Schema::create('pf_package_orders', function (Blueprint $table): void {
            $table->id();
            $table->unsignedBigInteger('package_id')->nullable()->index();
            $table->string('package_name', 255);
            $table->string('package_price', 60)->default('0');
            $table->string('name', 255);
            $table->string('email', 255);
            $table->string('phone', 20)->nullable();
            $table->decimal('amount', 15, 2)->default(0);
            $table->string('status', 60)->default('pending');
            $table->string('payment_code', 100)->unique();
            $table->string('payment_method', 60)->default('sepay');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pf_package_orders');
    }
};
