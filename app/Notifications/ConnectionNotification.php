<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class ConnectionNotification extends Notification
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
        if ($this->object->var && $this->object->var != null) {
            $route = route($this->object->route);
        } else {
            $route = route($this->object->route, $this->object->var);
        }
        return (new MailMessage)
            ->subject($this->message)
            ->line($this->message)
            ->action('View User', $route)
            ->line('Thank you for being a part of our platform!');
    }
}
