<?php

namespace App\Listeners;

use App\Events\prestartCycling1;
use App\Studentinfo;
use GuzzleHttp\Client;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Redis;
class prestartCyclinglistener1
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //dd('inja');
    }

    /**
     * Handle the event.
     *
     * @param  prestartCycling1  $event
     * @return void
     */
    public function handle(prestartCycling1 $event)
    {

     $redis = Redis::connection();
        if ($event->nextRoundNum) {

            $user = Studentinfo::all()->where('roundNumber',(int) $event->nextRoundNum);
            $Qusers = $user->where('QorR', 1);//Todo wherer client must web
            $userscollect = collect();
            $Resp = $user->where('QorR', 0);
            $restel=collect();
            $resand=collect();
            foreach ($Resp as $r) {
                $redis = \Redis::connection();
                if($r->platform=='web')
                {
                $redis->publish('RespondentModal', $r->participantID);
                }
                else if($r->platform=='android')
                {
                    $resand->push($r->participantID);
                }
                else 
                {
                    $restel->push($r->participantID);
                }
            }
         
            if(!$restel->isEmpty())
            {

                $sendrestel=collect();
                $sendrestel->put('roundnumber',1);
                $sendrestel->put('user',$restel);
                $sendrestel->put('ticket','justforfun');
                try {
                    $client = new Client();
                    $response = $client->request('POST', 'http://51.254.79.207:9000/responderTurns', [
                        'body' => $sendrestel
                ]);
            } catch (\Exception $e) {
                $redis->publish('log',$e);
            }
}
if(!$resand->isEmpty()) {
           

$sendresand=collect();
$sendresand->put('users',$resand);
$sendresand->put('ticket','justforfun');

try {
                $client = new Client();
                $response = $client->request('POST', 'http://54.67.65.222:3000/androidgameserver/turningPost1', [
                    'json' => $sendresand
                ]);
            } catch (\Exception $e) {

            }

}



            $telegramQ = collect();
            $telegramQ->put('roundnumber', $event->nextRoundNum);
            $androidlist=collect();
            $androidlist->put('roundnumber',$event->nextRoundNum);
            $telTemplist = collect();
            $androidtemp=collect();

            foreach ($Qusers as $userq) {

                if ($userq->platform == 'web') {
                    $tmp = collect();
                    $tmp->put('userid', $userq->participantID);
                    $tmp->put('roundnumber', $event->nextRoundNum);
                    $userscollect->push($tmp);
                } else if($userq->platform=='telegram') {
                    $telTemplist->push($userq->participantID);

                }
                else
                {
                $androidtemp->push($userq->participantID);
                }


            }
            $androidlist->put('users',$androidtemp);
            $telegramQ->put('user', $telTemplist);
            $flist = collect();
            $flist->put('users', $userscollect);
            $redis = \Redis::connection();
            $redis->publish('message', $flist);
           // $redis->publish('log',$flist);
            /// telegram send
            $Qusers = $user->where('QorR', 1);//Todo where is telegram user
            $userscollect = collect();
           //  $redis->publish('log',$telegramQ->toJson());
            if(!$telTemplist->isEmpty()) {
            try {
                $client = new Client();
                $response = $client->request('POST', 'http://51.254.79.207:9000/turns', [
                    'body' => $telegramQ
                ]);
            } catch (\Exception $e) {
//$redis->publish('log',$e);
            }

}
            try {
                $client = new Client();
                $response = $client->request('POST', 'http://54.67.65.222:3000/androidgameserver/turningPost', [
                    'json' => $androidlist
                ]);

            } catch (\Exception $e) {

            }
            //Todo send to telegram flist


        }
    }
}
