<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Twilio\Rest\Client;

class SendWhatsAppTest extends Command
{
    protected $signature = 'whatsapp:test {phone}';
    protected $description = 'Test sending a WhatsApp message via Twilio';

    public function handle()
    {
        $sid = config('services.twilio.sid');
        $token = config('services.twilio.token');
        $from = config('services.twilio.whatsapp_from');

        $this->info("SID: " . substr($sid, 0, 5) . "...");
        $this->info("From: $from");

        try {
            $httpClient = new \Twilio\Http\GuzzleClient(new \GuzzleHttp\Client(['verify' => false]));
            $twilio = new Client($sid, $token, null, null, $httpClient);
            
            $message = $twilio->messages->create(
                "whatsapp:" . $this->argument('phone'),
                [
                    "from" => $from,
                    "body" => "Hello from Rose Villa! This is a test message."
                ]
            );

            $this->info("Message sent! SID: " . $message->sid);
        } catch (\Exception $e) {
            $this->error("Error: " . $e->getMessage());
        }
    }
}
