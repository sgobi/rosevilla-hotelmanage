<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\Reservation;

foreach(Reservation::latest()->take(5)->get() as $r) {
    echo "ID: {$r->id}\n";
    echo "Guest: {$r->guest_name}\n";
    echo "Total Price: {$r->total_price}\n";
    echo "Tax %: {$r->tax_percentage}\n";
    echo "Tax Amount: {$r->tax_amount}\n";
    echo "Discount %: {$r->discount_percentage}\n";
    echo "Discount Status: {$r->discount_status}\n";
    echo "Check In: " . ($r->check_in ? $r->check_in->format('Y-m-d') : 'NULL') . "\n";
    echo "Check Out: " . ($r->check_out ? $r->check_out->format('Y-m-d') : 'NULL') . "\n";
    echo "Final Price: " . $r->final_price . "\n";
    echo "-------------------\n";
}
