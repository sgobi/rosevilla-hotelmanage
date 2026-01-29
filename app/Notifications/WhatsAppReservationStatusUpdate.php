<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Log;

class WhatsAppReservationStatusUpdate extends Notification
{
    use Queueable;

    public $reservation;
    public $status; // 'approved' or 'cancelled'

    /**
     * Create a new notification instance.
     */
    public function __construct($reservation, $status)
    {
        $this->reservation = $reservation;
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
        $formattedPhone = $this->formatPhoneNumber($this->reservation->phone);
        
        // Construct message based on status
        if ($this->status === 'approved') {
            $message = "Dear {$this->reservation->guest_name},\n\n" .
                "Great news! Your reservation at Rosevilla has been APPROVED! ✅\n\n" .
                "📅 Check-in: " . $this->reservation->check_in->format('M d, Y') . "\n" .
                "📅 Check-out: " . $this->reservation->check_out->format('M d, Y') . "\n" .
                "🏨 Room: {$this->reservation->room->title}\n" .
                "💰 Total: LKR " . number_format($this->reservation->total_price, 2) . "\n\n" .
                "We look forward to welcoming you to Rosevilla!";
        } else {
            // Cancelled/Rejected
            $message = "Dear {$this->reservation->guest_name},\n\n" .
                "We regret to inform you that your reservation at Rosevilla has been CANCELLED. ❌\n\n" .
                "📅 Dates: " . $this->reservation->check_in->format('M d, Y') . " - " . $this->reservation->check_out->format('M d, Y') . "\n" .
                "🏨 Room: {$this->reservation->room->title}\n\n" .
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
