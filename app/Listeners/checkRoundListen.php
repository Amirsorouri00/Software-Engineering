<?php

namespace App\Listeners;

use App\Events\checkRound;
use App\Studentinfo;
use GuzzleHttp\Client;
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

        $Qusers = $user->where('QorR', 1);//Todo wherer client must web
        $userscollect = collect();
        $Resp = $user->where('QorR', 0);
        foreach ($Resp as $r) {
            $redis = Redis::connection();
            $redis->publish('RespondentModal', $r->participantID);


        }
        $e = 0;
        $telegramQ = collect();
        $telegramQ->put('roundnumber', $event->roundnumber);
        $telTemplist = collect();
        foreach ($Qusers as $userq) {

            if ($userq->platform == 'web') {
                $tmp = collect();
                $tmp->put('userid', $userq->participantID);
                $tmp->put('roundnumber', $event->roundnumber);
                $userscollect->push($tmp);
            } else {
                $telTemplist->push($userq->participantID);

            }


        }
        $telegramQ->put('users',$telTemplist);
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
            $response = $client->request('POST', 'http://172.17.10.252:2000/getPartBaskets', [
                'json' => $telegramQ
            ]);
        } catch (Exception $e) {

        }
        //Todo send to telegram flist

        //  dd(1);
    }
}
