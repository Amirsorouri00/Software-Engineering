<?php

namespace App\Listeners;

use App\Events\forceExit;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class foceExitListener
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
     * @param  forceExit  $event
     * @return void
     */
    public function handle(forceExit $event)
    {
    }
}
