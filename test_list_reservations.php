<?php

use App\Models\Reservation;

echo "Recent Reservations:\n";
echo str_repeat('-', 80) . "\n";

$reservations = Reservation::with('room')->latest()->take(5)->get();

foreach ($reservations as $r) {
    echo "ID: {$r->id}\n";
    echo "Guest: {$r->guest_name}\n";
    echo "Phone: {$r->phone}\n";
    echo "Room: {$r->room->title}\n";
    echo "Status: {$r->status}\n";
    echo "Check-in: {$r->check_in->format('M d, Y')}\n";
    echo str_repeat('-', 80) . "\n";
}
