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
        \Illuminate\Support\Facades\DB::statement("UPDATE rooms SET price_per_night = price_per_night * 300");
        \Illuminate\Support\Facades\DB::statement("UPDATE reservations SET total_price = total_price * 300");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        \Illuminate\Support\Facades\DB::statement("UPDATE rooms SET price_per_night = price_per_night / 300");
        \Illuminate\Support\Facades\DB::statement("UPDATE reservations SET total_price = total_price / 300");
    }
};
