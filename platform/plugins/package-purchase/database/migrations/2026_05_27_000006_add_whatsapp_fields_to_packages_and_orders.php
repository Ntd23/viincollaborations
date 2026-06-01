<?php

// English description: Adds WhatsApp contact and notification fields for package checkout orders.

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    public function up(): void
    {
        Schema::table('pf_packages', function (Blueprint $table): void {
            if (! Schema::hasColumn('pf_packages', 'whatsapp_phone_vi')) {
                $table->string('whatsapp_phone_vi', 50)->nullable()->after('action_url');
            }

            if (! Schema::hasColumn('pf_packages', 'whatsapp_phone_en')) {
                $table->string('whatsapp_phone_en', 50)->nullable()->after('whatsapp_phone_vi');
            }
        });

        Schema::table('package_orders', function (Blueprint $table): void {
            if (! Schema::hasColumn('package_orders', 'customer_whatsapp_phone')) {
                $table->string('customer_whatsapp_phone', 50)->nullable()->after('consultation_language');
            }

            if (! Schema::hasColumn('package_orders', 'whatsapp_notified_at')) {
                $table->timestamp('whatsapp_notified_at')->nullable()->after('paid_at');
            }

            if (! Schema::hasColumn('package_orders', 'whatsapp_notification_status')) {
                $table->string('whatsapp_notification_status', 30)->nullable()->after('whatsapp_notified_at');
            }

            if (! Schema::hasColumn('package_orders', 'whatsapp_notification_error')) {
                $table->text('whatsapp_notification_error')->nullable()->after('whatsapp_notification_status');
            }
        });
    }

    public function down(): void
    {
        Schema::table('package_orders', function (Blueprint $table): void {
            foreach (['whatsapp_notification_error', 'whatsapp_notification_status', 'whatsapp_notified_at', 'customer_whatsapp_phone'] as $column) {
                if (Schema::hasColumn('package_orders', $column)) {
                    $table->dropColumn($column);
                }
            }
        });

        Schema::table('pf_packages', function (Blueprint $table): void {
            foreach (['whatsapp_phone_en', 'whatsapp_phone_vi'] as $column) {
                if (Schema::hasColumn('pf_packages', $column)) {
                    $table->dropColumn($column);
                }
            }
        });
    }
};
