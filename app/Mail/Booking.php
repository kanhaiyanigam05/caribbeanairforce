<?php

namespace App\Mail;

use App\Enums\Timing;
use App\Helpers\Setting;
use App\Models\EventBooking;
use Carbon\Carbon;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class Booking extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     */
    public $data, $booking, $slots, $ticket;
    public function __construct($booking_id)
    {
        $this->booking = EventBooking::find($booking_id);
        $this->data = Setting::data();
        $this->slots = $this->booking->slots;
        $this->ticket = $this->booking->event->type === "ticket";
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->booking->name . ' booking successful',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.booking',
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