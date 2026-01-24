<?php

namespace App\Channels;

use Illuminate\Notifications\Notification;

class WhatsAppChannel
{
    /**
     * Send the given notification.
     */
    public function send($notifiable, Notification $notification): void
    {
        if (!method_exists($notification, 'toTwilio')) {
            return;
        }

        $data = $notification->toTwilio($notifiable);
        $to = $data['to'] ?? $notifiable->phone;
        $message = $data['body'];

        if (!$to) {
            \Illuminate\Support\Facades\Log::error('WhatsApp Notification Error: No phone number found for user.');
            return;
        }

        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $from = config('services.twilio.whatsapp_from');

        try {
            // Disable SSL verification for local development
            $httpClient = new \Twilio\Http\GuzzleClient(new \GuzzleHttp\Client(['verify' => false]));
            $twilio = new \Twilio\Rest\Client($sid, $token, null, null, $httpClient);

            $twilio->messages->create(
                "whatsapp:" . $to,
                [
                    "from" => $from,
                    "body" => $message
                ]
            );
            
            \Illuminate\Support\Facades\Log::info("WhatsApp sent to $to");

        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error('WhatsApp Twilio Error: ' . $e->getMessage());
        }
    }
}
