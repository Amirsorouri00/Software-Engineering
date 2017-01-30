<?php

namespace App\Events;

use App\Events\Event;
use App\Studentinfo;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Redis;
class prestartCycling1 extends Event
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
        
        if ($minNum == 0) {
            return;
        }


        $Qusers = $user->where('QorR', (int)1)->take($minNum);
        $Rusers = $user->where('QorR',(int) 0)->take($minNum);

        $this->nextRoundNum = Studentinfo::all()->max('roundNumberInd') + 1;
$newnum=Studentinfo::all()->max('roundNumberInd') ;
$newnum++;
         $redis=Redis::connection();

$redis->publish('log',$newnum);


        foreach ($Qusers as $quser) {

     $quser->roundNumberInd =$newnum;
//$quser->roundNumberInd=$quser->roundNumberInd+1;
            
            $quser->save();
        }
       
         foreach ($Rusers as $ruser) {

            $ruser->roundNumberInd = $newnum-1;
            $ruser->roundNumberInd=$ruser->roundNumberInd+1;
              // $ruser->individualStatus = 1;//Todo
            $ruser->save();

        }
         $redis=Redis::connection();
  $user = Studentinfo::all();
//$redis->publish('log',$user);
        $r = \Redis::connection();
        $l = collect();
        $l->put('roundnumber', $this->nextRoundNum);
        $l->put('time', 30);
        $r->sadd('round', json_encode($l));
        $r->set('lastroundtime',300);
       
         

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
