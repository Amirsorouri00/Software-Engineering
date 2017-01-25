<?php

namespace App\Listeners;

use App\Events\prestartCycling;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class prestartCyclinglistener
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
     * @param  prestartCycling $event
     * @return void
     */
    public function handle(prestartCycling $event)
    {
        if (min($event->Qsize, $event->Rsize) > 20) {
            Event::fire(new \App\Events\startCycling());
        } else {

        }
    }
}
