<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CategoryEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $category;
    public $action; // example pour 'created', 'updated', 'deleted'

    /**
     * Create a new event instance.
     * 
     * @param mixed  $category
     * @param  string  $action
     * @return void
     */
    public function __construct($category, $action)
    {
        $this->category = $category;
        $this->action = $action;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('channel-name'),
        ];
    }
}
