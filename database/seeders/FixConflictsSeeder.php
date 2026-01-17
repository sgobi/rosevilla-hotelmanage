<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\EventBooking;

class FixConflictsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $bookings = EventBooking::where('status', 'pending')
                                ->where('conflict_status', 'none')
                                ->get();

        foreach ($bookings as $booking) {
            // Check for conflicts excluding this event
            $hasConflict = EventBooking::where('id', '!=', $booking->id)
                ->where('event_date', $booking->event_date)
                ->where('status', '!=', 'cancelled')
                ->where('status', '!=', 'rejected')
                ->where(function ($query) use ($booking) {
                    $query->where('start_time', '<', $booking->end_time->format('H:i:s'))
                          ->where('end_time', '>', $booking->start_time->format('H:i:s'));
                })
                ->exists();

            if ($hasConflict) {
                $booking->update(['conflict_status' => 'requested']);
                $this->command->info("Flagged booking ID {$booking->id} as conflict requested.");
            }
        }
    }
}
