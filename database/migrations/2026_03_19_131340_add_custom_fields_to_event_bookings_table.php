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
            $table->string('address')->nullable()->after('customer_phone');
            $table->date('check_out')->nullable()->after('event_date');
            $table->time('arrival_time')->nullable()->after('check_out');
            $table->json('room_ids')->nullable()->after('guests');
            $table->boolean('garden_selection')->default(false)->after('room_ids');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('event_bookings', function (Blueprint $table) {
            $table->dropColumn(['address', 'check_out', 'arrival_time', 'room_ids', 'garden_selection']);
        });
    }
};
