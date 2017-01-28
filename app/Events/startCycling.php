<?php

namespace App\Events;

use App\Studentinfo;
use App\Events\Event;
use Carbon\Carbon;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Redis;
class startCycling extends Event
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public $nextRoundNum;


    public function __construct()
    {

        $user = Studentinfo::getFree();//get free student
        



        $Qsize = $user->where('QorR', 1)->count();
        $Rsize = $user->where('QorR', 0)->count();


        $minNum = min($Qsize, $Rsize);
        //dd($minNum);
        if ($minNum == 0) {
            return;
        }


        $Qusers = $user->where('QorR', 1)->take($minNum);
        $Rusers = $user->where('QorR', 0)->take($minNum);

     $this->nextRoundNum = Studentinfo::all()->max('roundNumber') + 1;

  
        foreach ($Qusers as $quser) {

            $quser->roundNumber =$this->nextRoundNum;
            
         //   $quser->individualStatus = 1;
            $quser->save();
        }
        /*
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
        */
        $r = Redis::connection();
        $l = collect();
        $l->put('roundnumber', $this->nextRoundNum);
        $l->put('time', 30);
        $r->sadd('round', json_encode($l));

        foreach ($Rusers as $ruser) {

            $ruser->roundNumber = $this->nextRoundNum;
        //     $ruser->individualStatus = 1;//Todo 
        $ruser->save();

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
