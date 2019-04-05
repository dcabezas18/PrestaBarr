<?php

namespace Prestabarr\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class DolibarrChangeProductPriceEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $ref;

    public $price;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($ref, $price)
    {
        $this->ref = $ref;
        $this->price = $price;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
