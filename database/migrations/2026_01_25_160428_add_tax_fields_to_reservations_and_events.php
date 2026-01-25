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
            $table->decimal('tax_percentage', 5, 2)->default(0)->after('total_price');
            $table->decimal('tax_amount', 12, 2)->default(0)->after('tax_percentage');
        });

        Schema::table('event_bookings', function (Blueprint $table) {
            $table->decimal('tax_percentage', 5, 2)->default(0)->after('total_price');
            $table->decimal('tax_amount', 12, 2)->default(0)->after('tax_percentage');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn(['tax_percentage', 'tax_amount']);
        });

        Schema::table('event_bookings', function (Blueprint $table) {
            $table->dropColumn(['tax_percentage', 'tax_amount']);
        });
    }
};
