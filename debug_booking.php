<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\EventBooking;

$b = new EventBooking();
$b->customer_name = 'Test';
$b->customer_email = 'test@test.com';
$b->customer_phone = '123';
$b->event_type = 'Party';
$b->event_date = '2026-03-01';
$b->start_time = '10:00';
$b->end_time = '12:00';
$b->guests = 10;
$b->status = 'pending';
$b->save();

echo "ID: " . $b->id . "\n";
print_r($b->getAttributes());
