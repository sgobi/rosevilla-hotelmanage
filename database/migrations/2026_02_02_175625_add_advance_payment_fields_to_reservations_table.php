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
            $table->decimal('advance_amount', 15, 2)->nullable();
            $table->string('advance_payment_method')->nullable(); // bank, cash
            $table->timestamp('advance_paid_at')->nullable();
            $table->string('advance_guest_name')->nullable();
            $table->string('advance_nic_no')->nullable();
            $table->string('advance_bank_name')->nullable();
            $table->string('advance_bank_branch')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn([
                'advance_amount',
                'advance_payment_method',
                'advance_paid_at',
                'advance_guest_name',
                'advance_nic_no',
                'advance_bank_name',
                'advance_bank_branch'
            ]);
        });
    }
};
