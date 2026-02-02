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
            $table->decimal('final_payment_amount', 15, 2)->nullable();
            $table->string('final_payment_method')->nullable(); // bank, cash
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
        Schema::table('reservations', function (Blueprint $table) {
            $table->dropColumn([
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
