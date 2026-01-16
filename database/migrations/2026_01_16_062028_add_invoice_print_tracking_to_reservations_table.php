<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            if (!Schema::hasColumn('reservations', 'invoice_print_count')) {
                $table->integer('invoice_print_count')->default(0)->after('discount_approved_by');
            }
            if (!Schema::hasColumn('reservations', 'invoice_reprint_status')) {
                $table->string('invoice_reprint_status')->default('none')->after('invoice_print_count'); // none, requested, approved
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn(['invoice_print_count', 'invoice_reprint_status']);
        });
    }
};
