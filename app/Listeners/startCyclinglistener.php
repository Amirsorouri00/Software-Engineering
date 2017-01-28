<?php

namespace App\Listeners;

use App\Events\startCycling;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class startCyclinglistener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  startCycling  $event
     * @return void
     */
    public function handle(startCycling $event)
    {

        if($event->nextRoundNum)
       {



        Event::fire(new \App\Events\checkRound($event->nextRoundNum));
       }

}
}
