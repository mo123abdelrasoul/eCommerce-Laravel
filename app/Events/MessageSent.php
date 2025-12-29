<?php

namespace App\Events;

use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Queue\SerializesModels;
use InvalidArgumentException;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;

    public function __construct($message)
    {
        $this->message = $message;
    }

    public function broadcastOn()
    {
        $allowedTypes = ['admin', 'customer', 'vendor'];

        if (!in_array($this->message->receiver_type, $allowedTypes)) {
            throw new InvalidArgumentException('Invalid receiver type');
        }

        return new PrivateChannel(
            'chat.' . $this->message->receiver_type . '.' . $this->message->receiver_id
        );
    }
}
