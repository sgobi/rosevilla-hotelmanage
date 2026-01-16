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
            $table->decimal('discount_percentage', 5, 2)->default(0)->after('total_price'); // e.g., 10.00 for 10%
            $table->string('discount_status')->default('none')->after('discount_percentage'); // none, pending, approved, rejected
            $table->foreignId('discount_approved_by')->nullable()->after('discount_status')->constrained('users')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropForeign(['discount_approved_by']);
            $table->dropColumn(['discount_percentage', 'discount_status', 'discount_approved_by']);
        });
    }
};
