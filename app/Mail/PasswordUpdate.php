<?php

namespace App\Mail;

use App\Helpers\Setting;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PasswordUpdate extends Mailable
{
    use Queueable, SerializesModels;

    public $data, $user, $password, $role;
    public function __construct($user, $password, $role = null)
    {
        $this->data = Setting::data();
        $this->user = (object) $user;
        $this->password = $password;
        $this->role = $role;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Password Update',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.password-update',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}