<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SentMessage implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $message;
    public function __construct($message)
    {
        $this->message = $message;
    }

    /**01
     * @r8eturn Channel|PrivateChannel
     */
    public function broadcastOn()
    {
        if ($this->message->recipient_id) {
            return new PrivateChannel('user.' . $this->message->recipient_id);
        } else {
            return new Channel('public-chat');
        }
    }

    public function broadcastAS()
    {
        return 'message';
    }
}
