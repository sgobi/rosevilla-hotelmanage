<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use App\Models\ContentSetting;

class InvoiceMail extends Mailable
{
    use Queueable, SerializesModels;

    public $booking;
    public $type;
    public $content;
    public $days;
    public $isProforma;

    /**
     * Create a new message instance.
     */
    public function __construct($booking, $type, $isProforma = false)
    {
        $this->booking = $booking;
        $this->type = $type;
        $this->isProforma = $isProforma;
        $this->content = ContentSetting::pluck('value', 'key');
        
        if ($type === 'reservation' || $type === 'garden') {
            $this->days = max(1, $booking->check_in->diffInDays($booking->check_out));
        } else {
            $this->days = $booking->duration;
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        $subject = ($this->isProforma ? 'Proforma Invoice / Quotation' : 'Booking Confirmation') . ' - Rose Villa';
        
        return new Envelope(
            subject: $subject,
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        $view = match($this->type) {
            'reservation' => 'emails.invoices.reservation',
            'event' => 'emails.invoices.event',
            'garden' => 'emails.invoices.garden',
        };

        return new Content(
            view: $view,
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
