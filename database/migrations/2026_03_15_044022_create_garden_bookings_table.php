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
        Schema::create('garden_bookings', function (Blueprint $table) {
            $table->id();
            
            // Customer Info
            $table->string('guest_name');
            $table->string('email');
            $table->string('phone')->nullable();
            $table->string('address', 500)->nullable();
            
            // Booking Details
            $table->date('check_in');
            $table->date('check_out');
            $table->integer('guests')->default(1);
            $table->text('special_requirements')->nullable();
            $table->text('additional_notes')->nullable();
            
            // Status & Timestamps
            $table->string('status')->default('pending'); // pending, approved, checked_in, checked_out, cancelled, rejected
            $table->text('cancellation_reason')->nullable();
            
            // Pricing & Tax
            $table->decimal('total_price', 10, 2)->default(0);
            $table->decimal('tax_percentage', 5, 2)->default(0);
            $table->decimal('tax_amount', 10, 2)->default(0);
            
            // Discounts
            $table->decimal('discount_percentage', 5, 2)->default(0);
            $table->string('discount_status')->default('pending'); // pending, approved, rejected
            $table->foreignId('discount_approved_by')->nullable()->constrained('users')->nullOnDelete();
            
            // Operational
            $table->timestamp('checked_in_at')->nullable();
            $table->timestamp('checked_out_at')->nullable();
            
            // Advance Payment Tracking 
            $table->decimal('advance_amount', 10, 2)->default(0);
            $table->string('advance_payment_method')->nullable();
            $table->timestamp('advance_paid_at')->nullable();
            $table->string('advance_guest_name')->nullable();
            $table->string('advance_nic_no')->nullable();
            $table->string('advance_bank_name')->nullable();
            $table->string('advance_bank_branch')->nullable();

            // Final Payment Tracking
            $table->decimal('final_payment_amount', 10, 2)->default(0);
            $table->string('final_payment_method')->nullable();
            $table->timestamp('final_payment_at')->nullable();
            $table->string('final_guest_name')->nullable();
            $table->string('final_nic_no')->nullable();
            $table->string('final_bank_name')->nullable();
            $table->string('final_bank_branch')->nullable();
            
            $table->integer('invoice_print_count')->default(0);
            $table->boolean('invoice_reprint_status')->default(false);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('garden_bookings');
    }
};
