<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DiscountDecision extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    protected $data;

    /**
     * Create a new notification instance.
     */
    public function __construct($data)
    {
        $this->data = $data;
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
        return [
            'reservation_id' => $this->data['reservation_id'] ?? null,
            'garden_booking_id' => $this->data['garden_booking_id'] ?? null,
            'message' => 'Discount ' . $this->data['status'] . ': ' . $this->data['guest_name'],
            'action_url' => $this->data['action_url'] ?? route('admin.reservations.index', [], false),
            'type' => 'decision',
            'status' => $this->data['status']
        ];
    }
}
