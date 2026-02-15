<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

use App\Models\EventBooking;
use Illuminate\Support\Facades\DB;

// 1. Clear and create first booking
EventBooking::where('event_date', '2026-03-01')->delete();

$b1 = new EventBooking();
$b1->customer_name = 'First';
$b1->customer_email = 'first@test.com';
$b1->customer_phone = '123';
$b1->event_type = 'Party';
$b1->event_date = '2026-03-01';
$b1->start_time = '10:00';
$b1->end_time = '12:00';
$b1->guests = 10;
$b1->status = 'approved';
$b1->save();

echo "Booking 1 ID: " . $b1->id . "\n";

// 2. Try to create overlapping booking using FIX
$date = '2026-03-01';
$start = '11:00';
$end = '13:00';

$conflict = EventBooking::whereDate('event_date', $date)
    ->where('status', '!=', 'cancelled')
    ->where('status', '!=', 'rejected')
    ->where(function ($query) use ($start, $end) {
        $query->where('start_time', '<', $end)
              ->where('end_time', '>', $start);
    })
    ->first();

if ($conflict) {
    echo "CONFLICT DETECTED: Overlaps with " . $conflict->customer_name . "\n";
} else {
    echo "NO CONFLICT detected (Fail!)\n";
}
