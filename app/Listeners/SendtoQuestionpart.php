<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use illuminate\Events\Dispatcher;
use GuzzleHttp\client;
class SendtoQuestionpart
{
    /**
     * Handle round start in send to question part
     */
    public function startRound($event) {

     //   dd($event->list);
    $client = new Client();
/*
        $response = $client->post('http://bit.com:8585/posttest', [
            'json' => ['foo' => 'bar']
        ]);
  */
       // dd($response);
        /*
        $redis = Redis::connection();
        Redis::set('name', 'Taylor');

        $redis->set('asd','dsfs');
        //  $redis->publish('message2', "sdfsdf");
        $redis->publish('message',"startRound");
*/
    }

    /**
     * Handle volunteer part in send to question part.
     */
    public function handelvolunteer($event) {

        /*$redis = Redis::connection();
        Redis::set('name', 'Taylor');

        $redis->set('asd','dsfs');
        //  $redis->publish('message2', "sdfsdf");
        $redis->publish('message',"handelvolunteer");
*/


    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher  $events
     */
    public function subscribe($events)
    {
        $events->listen(
            'App\Events\Cycling',
            'App\Listeners\SendtoQuestionpart@startRound'
        );

        $events->listen(
            'App\Events\volunteerToQusteinpart',
            'App\Listeners\SendtoQuestionpart@handelvolunteer'
        );

        $events->listen('App\Events\socketio',
        'App\Listeners\eventlistener@handle');
    }

}