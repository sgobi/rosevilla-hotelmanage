<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\EventBooking;
use App\Notifications\WhatsAppEventStatusUpdate;

class TestWhatsAppEvent extends Command
{
    protected $signature = 'test:whatsapp-event {event_id} {status}';
    protected $description = 'Test WhatsApp notification for event booking status update';

    public function handle()
    {
        $eventId = $this->argument('event_id');
        $status = $this->argument('status');

        if (!in_array($status, ['approved', 'rejected', 'cancelled'])) {
            $this->error('Status must be "approved", "rejected", or "cancelled"');
            return 1;
        }

        $event = EventBooking::find($eventId);

        if (!$event) {
            $this->error("Event Booking #{$eventId} not found!");
            return 1;
        }

        $this->info("Testing WhatsApp notification for Event Booking #{$eventId}");
        $this->info("Customer: {$event->customer_name}");
        $this->info("Phone: {$event->customer_phone}");
        $this->info("Event Type: {$event->event_type}");
        $this->info("Status: {$status}");
        $this->newLine();

        try {
            $event->notify(new WhatsAppEventStatusUpdate($event, $status));
            $this->info('✅ WhatsApp notification sent successfully!');
            $this->info('Check the customer\'s WhatsApp for the message.');
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
