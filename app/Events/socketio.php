<?php

namespace App\Events;

use Illuminate\Console\Scheduling\Event;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class socketio extends Event implements ShouldBroadcast
{
    use SerializesModels;

    /**
     * Create a new event instance.
     * @return void
     */
    public $data;
    public function __construct()
    {
        //
        $this->data = array(
            'power'=> '10'
        );
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return ['amir'];
    }
}
