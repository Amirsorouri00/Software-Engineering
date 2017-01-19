<?php

namespace App\Listeners;
use Illuminate\Support\Facades\Redis;

use App\Events\socketio;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

class eventlistener
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
     * @param  EventName  $event
     * @return void
     */
    public function handle(socketio $event)
    {
        $redis = Redis::connection();
        $redis->publish('message','javad');
    }
}
