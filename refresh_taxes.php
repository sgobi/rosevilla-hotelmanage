<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$taxRate = \App\Models\ContentSetting::getValue('tax_percentage', 0);
echo "System Tax Rate: {$taxRate}%\n";

echo "Updating Reservations...\n";
$reservations = \App\Models\Reservation::all();
foreach ($reservations as $r) {
    if ($r->discount_status === 'approved' && $r->discount_percentage > 0) {
        echo "Updating ID: {$r->id} with Approved Discount: {$r->discount_percentage}%\n";
    }
    $r->save();
}

echo "Updating Event Bookings...\n";
$events = \App\Models\EventBooking::all();
foreach ($events as $e) {
    if ($e->discount_status === 'approved' && $e->discount_percentage > 0) {
        echo "Updating ID: {$e->id} with Approved Discount: {$e->discount_percentage}%\n";
    }
    $e->save();
}
echo "Refresh complete.\n";
