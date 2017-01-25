<?php

namespace App\Events;

use App\Events\Event;
use Carbon\Carbon;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class startCycling extends Event
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public  $nextRoundNum;
    public function __construct()
    {



        //
        $user = Studentinfo::all()->where('individualStatus', 0);//get free student
        $Qsize = $user->where('QorR', 1)->count();
        $Rsize = $user->where('QorR', 0)->count();


        $nextRoundNum = Studentinfo::all()->max('roundNumber') + 1;
        $minNum = min($Qsize, $Rsize);

        $Qusers = $user->where('QorR', 1)->take($minNum);
        $Rusers = $user->where('QorR', 0)->take($minNum);
        foreach ($Qusers as $quser) {

            $quser->roundNumber = $nextRoundNum;
            $quser->save();
            //    $quser->individualStatus = 1; Todo

        }

        $r = Redis::connection();
        $l = collect();
        $l->put('roundnumber', $nextRoundNum);
        $lastROundTime = Exam::firstorfail();
        $lastROundTime->lastRound_time=Carbon::now();
        $lastROundTime->save();
        $r.set('lastroundtime',$lastROundTime);
        $ttt = Carbon::now();
        $l->put('time', $ttt);
        $r->sadd('round', json_encode($l));


        foreach ($Rusers as $ruser) {

            $ruser->roundNumber = $nextRoundNum;
            $ruser->save();
            //   $ruser->individualStatus = 1;Todo
        }
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
