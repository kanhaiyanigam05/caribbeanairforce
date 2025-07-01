<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventBookingNotification extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public $message, $object;
    public function __construct($message, $object)
    {
        $this->message = $message;
        $this->object = (object)$object;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database', 'mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toDatabase($notifiable)
    {
        return [
            'message' => $this->message,
            'object' => $this->object,
        ];
    }
    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject($this->message)
            ->line($this->message)
            ->action('View Event', route($this->object->route, $this->object->var))
            ->line('Thank you for being a part of our platform!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
