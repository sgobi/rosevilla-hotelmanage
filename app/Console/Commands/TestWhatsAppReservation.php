<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Reservation;
use App\Notifications\WhatsAppReservationStatusUpdate;

class TestWhatsAppReservation extends Command
{
    protected $signature = 'test:whatsapp-reservation {reservation_id} {status}';
    protected $description = 'Test WhatsApp notification for reservation status update';

    public function handle()
    {
        $reservationId = $this->argument('reservation_id');
        $status = $this->argument('status');

        if (!in_array($status, ['approved', 'cancelled'])) {
            $this->error('Status must be either "approved" or "cancelled"');
            return 1;
        }

        $reservation = Reservation::with('room')->find($reservationId);

        if (!$reservation) {
            $this->error("Reservation #{$reservationId} not found!");
            return 1;
        }

        $this->info("Testing WhatsApp notification for Reservation #{$reservationId}");
        $this->info("Guest: {$reservation->guest_name}");
        $this->info("Phone: {$reservation->guest_phone ?? $reservation->phone}");
        $this->info("Status: {$status}");
        $this->newLine();

        try {
            $reservation->notify(new WhatsAppReservationStatusUpdate($reservation, $status));
            $this->info('✅ WhatsApp notification sent successfully!');
            $this->info('Check the guest\'s WhatsApp for the message.');
            return 0;
        } catch (\Exception $e) {
            $this->error('❌ Failed to send WhatsApp notification:');
            $this->error($e->getMessage());
            $this->newLine();
            $this->warn('Check your Twilio credentials in .env file');
            return 1;
        }
    }
}
