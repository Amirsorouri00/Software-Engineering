<?php

namespace App\Listeners;

use App\Events\checkRound;
use App\Studentinfo;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Redis;

class checkRoundListen
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
     * @param  checkRound $event
     * @return void
     */
    public function handle(checkRound $event)
    {
        $user = Studentinfo::all()->where('roundNumber', $event->roundnumber);

        $Qusers = $user->where('QorR', 1);
        $userscollect = collect();

        $e = 0;
        foreach ($Qusers as $user) {
            $tmp = collect();
            $tmp->put('userid', $user->participantID);
            $tmp->put('roundnumber', $event->roundnumber);

            $userscollect->push($tmp);

        }
        $flist = collect();
        $flist->put('users', $userscollect);
        // dd($aa->all());
        //dd($flist->all());
        $redis = Redis::connection();
        $redis->publish('message', $flist);
      //  dd(1);
    }
}
