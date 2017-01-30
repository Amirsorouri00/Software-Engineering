<?php

namespace App\Listeners;

use App\Events\startCycling;
use App\Studentinfo;

use GuzzleHttp\Client;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;

use Psy\Exception\Exception;
use Redis;

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
     * @param  startCycling $event
     * @return void
     */
    public function handle(startCycling $event)
    {
        if ($event->nextRoundNum) {

            $user = Studentinfo::all()->where('roundNumber', $event->nextRoundNum);

            $Qusers = $user->where('QorR', 1);//Todo wherer client must web
            $userscollect = collect();
            $Resp = $user->where('QorR', 0);
            foreach ($Resp as $r) {
                $redis = Redis::connection();
                $redis->publish('RespondentModal', $r->participantID);


            }
            $e = 0;
            $telegramQ = collect();
            $telegramQ->put('roundnumber', $event->nextRoundNum);
            $telTemplist = collect();
            foreach ($Qusers as $userq) {

                if ($userq->platform == 'web') {
                    $tmp = collect();
                    $tmp->put('userid', $userq->participantID);
                    $tmp->put('roundnumber', $event->nextRoundNum);
                    $userscollect->push($tmp);
                } else {
                    $telTemplist->push($userq->participantID);

                }


            }
            $telegramQ->put('users', $telTemplist);
            $flist = collect();
            $flist->put('users', $userscollect);
            // dd($aa->all());
            //dd($flist->all());
            $redis = Redis::connection();
            $redis->publish('message', $flist);


            /// telegram send
            $Qusers = $user->where('QorR', 1);//Todo where is telegram user
            $userscollect = collect();


            try {
                $client = new Client();
                $response = $client->request('POST', 'http://51.254.79.221:8002/turns', [
                    'json' => $telegramQ
                ]);
                dd($response->getBody());
            } catch (Exception $e) {

            }
            //Todo send to telegram flist

            //  dd(1);

        }

    }
}
