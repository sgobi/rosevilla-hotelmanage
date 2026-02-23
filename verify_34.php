<?php
require 'vendor/autoload.php';
$app = require_once 'bootstrap/app.php';
$app->make('Illuminate\Contracts\Console\Kernel')->bootstrap();

$r = App\Models\Reservation::find(34);
if ($r) {
    echo "RESERVATION 34:\n";
    echo "Total: {$r->total_price}\n";
    echo "Discount: {$r->discount_percentage}%\n";
    echo "Discount Amount: {$r->discount_amount}\n";
    echo "Tax: {$r->tax_amount}\n";
    echo "Final: {$r->final_price}\n";
}
