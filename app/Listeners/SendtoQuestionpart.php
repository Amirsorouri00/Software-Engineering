<?php

namespace App\Listeners;
use Exception;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Storage;
use illuminate\Events\Dispatcher;
use GuzzleHttp\client;

class SendtoQuestionpart
{
    /**
     * Handle round start in send to question part
     */
    public function startRound($event)
    {

        $redis = Redis::connection();

        //   dd($event->list);
        $client = new Client();
        $listforsend = collect();
        $temp = collect();
        $temp->put('basketsArray', $event->list);
        $listforsend->put('data', $temp);
        $listforsend->put('ticket', 'justforfun');
      // $redis->publish('log', $listforsend);
       try {
         $response = $client->post('http://77.244.214.149:3000/getPartBaskets', [
             'json' => $listforsend
         ]);
       } catch (Exception $e) {
//$redis->publish('log', 'error:send basket to question part');
       }




        foreach ($listforsend['data']['basketsArray'] as $l) {
            $redis2 = Redis::connection();
            $redis2->publish('redirect', $l['basket']['responderedID']);
            $redis2->publish('redirect', $l['basket']['questionerID']);
            # code...
        }
        //dd($response->getBody());
    }
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


    /**
     * Handle volunteer part in send to question part.
     */
    function handelvolunteer($event)
    {


    }

    /**
     * Register the listeners for the subscriber.
     *
     * @param  Illuminate\Events\Dispatcher $events
     */
    function subscribe($events)
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
