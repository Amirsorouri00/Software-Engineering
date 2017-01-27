<?php

namespace App\Events;

use App\Events\Event;
use App\Studentinfo;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class prestartCycling extends Event
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * check if free user is upper than 20 numbers
     * then fire startcycling event
     * @return void
     */
    public  $Qsize;
    public  $Rsize;
    public function __construct()
    {
        $user = Studentinfo::getFree();//get free student

        $this->Qsize = $user->where('QorR', 1)->count();
        $this->Rsize = $user->where('QorR', 0)->count();



    }

    /**
     * Get the channels the event should be broadcast on.
     *
     * @return array
     */
    public function broadcastOn()
    {
        return [];
    }
}
