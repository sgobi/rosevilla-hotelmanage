<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;

class WhatsAppEventStatusUpdate extends Notification
{
    use Queueable;

    public $event;
    public $status; // 'approved', 'rejected', or 'cancelled'

    /**
     * Create a new notification instance.
     */
    public function __construct($event, $status)
    {
        $this->event = $event;
        $this->status = $status;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return [\App\Channels\WhatsAppChannel::class];
    }

    /**
     * Get the Twilio representation of the notification.
     */
    public function toTwilio($notifiable)
    {
        $formattedPhone = $this->formatPhoneNumber($this->event->customer_phone);
        
        // Construct message based on status
        if ($this->status === 'approved') {
            $message = "Dear {$this->event->customer_name},\n\n" .
                "Great news! Your event booking at Rosevilla has been APPROVED! ✅\n\n" .
                "🎉 Event Type: {$this->event->event_type}\n" .
                "📅 Event Date: " . $this->event->event_date->format('M d, Y') . "\n" .
                "👥 Guests: {$this->event->number_of_guests}\n" .
                "💰 Total: LKR " . number_format($this->event->total_price, 2) . "\n\n" .
                "We look forward to making your event memorable at Rosevilla!";
        } elseif ($this->status === 'rejected') {
            $message = "Dear {$this->event->customer_name},\n\n" .
                "We regret to inform you that your event booking at Rosevilla has been REJECTED. ❌\n\n" .
                "🎉 Event Type: {$this->event->event_type}\n" .
                "📅 Event Date: " . $this->event->event_date->format('M d, Y') . "\n\n" .
                "If you have any questions or would like to discuss alternative dates, please contact us directly.\n\n" .
                "Thank you for considering Rosevilla.";
        } else {
            // Cancelled
            $message = "Dear {$this->event->customer_name},\n\n" .
                "Your event booking at Rosevilla has been CANCELLED. ❌\n\n" .
                "🎉 Event Type: {$this->event->event_type}\n" .
                "📅 Event Date: " . $this->event->event_date->format('M d, Y') . "\n\n" .
                "If you have any questions, please contact us directly.\n\n" .
                "Thank you for considering Rosevilla.";
        }

        return [
            'body' => $message,
            'to' => $formattedPhone
        ];
    }

    private function formatPhoneNumber($phone)
    {
        // Remove all non-numeric characters
        $phone = preg_replace('/[^0-9]/', '', $phone);
        
        // If it's a local Sri Lankan number (starts with 0 or is 9 digits)
        if (strlen($phone) <= 10) { 
            // Remove leading zero and add +94
            return '+94' . ltrim($phone, '0');
        }
        
        // If it already has country code
        if (!str_starts_with($phone, '+')) {
            return '+' . $phone;
        }
        
        return $phone;
    }
}
