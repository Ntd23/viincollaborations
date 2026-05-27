<?php

// English description: Adds date of birth to package customer profiles.

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::table('package_customers', function (Blueprint $table): void {
            if (! Schema::hasColumn('package_customers', 'dob')) {
                $table->date('dob')->nullable()->after('avatar');
            }
        });
    }

    public function down(): void
    {
        Schema::table('package_customers', function (Blueprint $table): void {
            if (Schema::hasColumn('package_customers', 'dob')) {
                $table->dropColumn('dob');
            }
        });
    }
};
