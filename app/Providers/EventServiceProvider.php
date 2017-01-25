<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use Illuminate\Contracts\Events\Dispatcher as DispatcherContract;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        'App\Events\socketio' => [
            'App\Listeners\eventlistener',],
        'App\Events\checkRound' => [
            'App\Listeners\checkRoundListen'
        ],
        'App\Events\prestartCycling' => [
            'App\Listeners\prestartCyclinglistener'
        ],
        'App\Events\startCycling' => [
            'App\Listeners\startCyclinglistener'
        ]
    ];


    protected $subscribe = [
        'App\Listeners\SendtoQuestionpart',
    ];

    /**
     * Register any other events for your application.
     *
     * @param  \Illuminate\Contracts\Events\Dispatcher $events
     * @return void
     */
    public function boot(DispatcherContract $events)
    {
        parent::boot($events);

        //
    }
}
