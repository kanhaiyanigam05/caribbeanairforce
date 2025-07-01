<?php

namespace App\Notifications;

use App\Events\EventBroadcast;
use Illuminate\Broadcasting\Channel;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class EventNotification extends Notification
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
        return ['mail', 'database'];
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
            ->subject('New Event Created: ' . $this->object->title)
            ->line('A new event has been created: ' . $this->object->title)
            ->action('View Event', route($this->object->route, $this->object->var))
            ->line('Thank you for being a part of our platform!');
    }

    // public function toBroadcast($notifiable)
    // {
    //     return new BroadcastMessage([
    //         'message' => $this->message,
    //         'object' => $this->object,
    //     ]);
    // }

    // public function broadcastOn(): Channel|array
    // {
    //     return new Channel('events');
    // }

    // public function broadcastAs()
    // {
    //     return 'new-event-created';
    // }
}
