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
        Schema::table('event_bookings', function (Blueprint $table) {
            // Operational Timestamps
            $table->timestamp('checked_in_at')->nullable();
            $table->timestamp('checked_out_at')->nullable();

            // Advance Payment
            $table->decimal('advance_amount', 15, 2)->nullable();
            $table->string('advance_payment_method')->nullable();
            $table->timestamp('advance_paid_at')->nullable();
            $table->string('advance_guest_name')->nullable();
            $table->string('advance_nic_no')->nullable();
            $table->string('advance_bank_name')->nullable();
            $table->string('advance_bank_branch')->nullable();

            // Final Payment
            $table->decimal('final_payment_amount', 15, 2)->nullable();
            $table->string('final_payment_method')->nullable();
            $table->timestamp('final_payment_at')->nullable();
            $table->string('final_guest_name')->nullable();
            $table->string('final_nic_no')->nullable();
            $table->string('final_bank_name')->nullable();
            $table->string('final_bank_branch')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_bookings', function (Blueprint $table) {
            $table->dropColumn([
                'checked_in_at',
                'checked_out_at',
                'advance_amount',
                'advance_payment_method',
                'advance_paid_at',
                'advance_guest_name',
                'advance_nic_no',
                'advance_bank_name',
                'advance_bank_branch',
                'final_payment_amount',
                'final_payment_method',
                'final_payment_at',
                'final_guest_name',
                'final_nic_no',
                'final_bank_name',
                'final_bank_branch'
            ]);
        });
    }
};
