<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewGardenBookingRequest extends Notification
{
    use Queueable;

    protected $booking;

    public function __construct($booking)
    {
        $this->booking = $booking;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'booking_id'  => $this->booking->id,
            'message'     => 'New garden booking request from ' . $this->booking->guest_name,
            'action_url'  => route('admin.garden-bookings.index', [], false),
            'type'        => 'new_garden_booking',
        ];
    }
}
