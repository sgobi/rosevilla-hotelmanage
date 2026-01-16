<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DiscountSuggested extends Notification
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
            'reservation_id' => $this->data['reservation_id'],
            'message' => $this->data['message'] ?? ('New discount suggestion: ' . $this->data['discount_percentage'] . '% for ' . $this->data['guest_name']),
            'action_url' => route('admin.reservations.index'),
            'type' => $this->data['type'] ?? 'suggestion'
        ];
    }
}
