<?php

// English description: Adds the selected consultation language to package orders.

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::table('package_orders', function (Blueprint $table): void {
            if (! Schema::hasColumn('package_orders', 'consultation_language')) {
                $table->string('consultation_language', 20)->nullable()->after('duration');
            }
        });
    }

    public function down(): void
    {
        Schema::table('package_orders', function (Blueprint $table): void {
            if (Schema::hasColumn('package_orders', 'consultation_language')) {
                $table->dropColumn('consultation_language');
            }
        });
    }
};
