<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class MailEvent implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public $to, $status;

    public function __construct($to, $status)
    {
        $this->to = $to;
        $this->status = $status;
    }

    public function broadcastOn()
    {
        return new Channel('emailing');
    }
    public function broadcastAs()
    {
        return 'MailEvent';
    }
}