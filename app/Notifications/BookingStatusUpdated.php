<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class BookingStatusUpdated extends Notification
{
    use Queueable;

    protected $booking;
    protected $type;
    protected $action; // approved, rejected

    /**
     * Create a new notification instance.
     */
    public function __construct($booking, $type, $action)
    {
        $this->booking = $booking;
        $this->type = $type; // discount, reprint, conflict
        $this->action = $action;
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
        $customerName = $this->booking->customer_name ?? $this->booking->guest_name ?? 'Guest';
        $message = '';

        switch ($this->type) {
            case 'discount':
                $message = "Discount {$this->action} for {$customerName}";
                break;
            case 'reprint':
                $message = "Reprint request {$this->action} for {$customerName}";
                break;
            case 'conflict':
                $message = "Booking conflict {$this->action} for {$customerName}";
                break;
            default:
                $message = "Booking status updated for {$customerName}";
        }

        // Determine if it's an event booking or reservation for the link
        $isEvent = isset($this->booking->event_type);
        $url = $isEvent 
            ? route('admin.events.index', [], false) 
            : route('admin.reservations.index', [], false);

        return [
            'booking_id' => $this->booking->id,
            'message' => $message,
            'action_url' => $url,
            'type' => 'status_update',
            'subtype' => $this->type,
            'status' => $this->action
        ];
    }
}
