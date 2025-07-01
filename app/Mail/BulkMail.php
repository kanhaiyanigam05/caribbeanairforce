<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Log;

class BulkMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subject, $body, $attachments;

    /**
     * Create a new message instance.
     */
    public function __construct($subject, $body, $attachments = [])
    {
        $this->subject = $subject;
        $this->body = $body;
        $this->attachments = $attachments;
    }

    public function build()
    {
        $email = $this->view('emails.bulk')
            ->subject($this->subject)
            ->with([
                'body' => $this->body,
            ]);

        // Attach the files
        foreach ($this->attachments as $attachment) {
            $email->attach($attachment['file'], $attachment['options']);
        }

        return $email;
    }

}