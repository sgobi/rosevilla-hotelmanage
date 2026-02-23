<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

echo "RESERVATIONS:\n";
$reservations = App\Models\Reservation::latest()->take(5)->get();
foreach ($reservations as $r) {
    echo "ID: {$r->id} | Total: {$r->total_price} | Tax%: {$r->tax_percentage} | TaxAmt: {$r->tax_amount} | Final: {$r->final_price}\n";
}

echo "\nEVENT BOOKINGS:\n";
$events = App\Models\EventBooking::latest()->take(5)->get();
foreach ($events as $e) {
    echo "ID: {$e->id} | Total: {$e->total_price} | Tax%: {$e->tax_percentage} | TaxAmt: {$e->tax_amount} | Final: {$e->final_price}\n";
}

echo "\nGLOBAL TAX SETTING: " . \App\Models\ContentSetting::getValue('tax_percentage', 'NOT SET') . "\n";
