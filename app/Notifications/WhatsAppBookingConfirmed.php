<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;

class WhatsAppBookingConfirmed extends Notification
{
    use Queueable;

    public $booking;
    public $type; // 'room' or 'event'

    /**
     * Create a new notification instance.
     */
    public function __construct($booking, $type = 'room')
    {
        $this->booking = $booking;
        $this->type = $type;
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
        $formattedPhone = $this->formatPhoneNumber($this->booking->customer_phone ?? $this->booking->phone ?? $this->booking->email);
        
        // Construct message based on type
        if ($this->type === 'event') {
            $message = "Dear {$this->booking->customer_name},\n\n" .
                "Thank you for choosing Rosevilla! We have received your event booking request for {$this->booking->event_type} on " . $this->booking->event_date->format('M d, Y') . ".\n\n" .
                "Status: Pending Approval\n" .
                "We will review your request and contact you shortly.";
        } else {
            // Room
            $message = "Dear {$this->booking->guest_name},\n\n" .
                "Thank you for booking with Rosevilla! Your reservation for {$this->booking->room->title} from {$this->booking->check_in->format('M d, Y')} to {$this->booking->check_out->format('M d, Y')} has been received.\n\n" .
                "We look forward to hosting you!";
        }

        return [
            'body' => $message,
            'to' => $formattedPhone
        ];
    }

    private function formatPhoneNumber($phone)
    {
        // simplistic formatting, assuming number comes in clean or needs + prefix
        // In production, use libphonenumber or similar
        $phone = preg_replace('/[^0-9]/', '', $phone);
        if (strlen($phone) <= 10) { 
             // Assume SL local, add +94
             return '+94' . ltrim($phone, '0');
        }
        return '+' . $phone;
    }
}
