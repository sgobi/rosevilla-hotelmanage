<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewEventBookingRequest extends Notification
{
    use Queueable;

    protected $booking;
    protected $type;

    /**
     * Create a new notification instance.
     */
    public function __construct($booking, $type = 'new_event_booking')
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
        return ['database'];
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $message = 'New event booking request: ' . $this->booking->event_type . ' for ' . $this->booking->customer_name;
        
        if ($this->type === 'discount_suggestion') {
            $message = 'Discount suggestion for ' . $this->booking->customer_name;
        } elseif ($this->type === 'reprint_request') {
            $message = 'Invoice reprint requested for ' . $this->booking->customer_name;
        }

        return [
            'booking_id' => $this->booking->id,
            'message' => $message,
            'action_url' => route('admin.events.index', [], false), // Or show/edit route if preferred
            'type' => $this->type
        ];
    }
}
