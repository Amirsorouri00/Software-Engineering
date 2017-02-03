<?php

namespace App\Http\Middleware;

use App\Studentinfo;
use App\Exam;
use Carbon\Carbon;
use Closure;
use Event;
use Faker\Provider\tr_TR\DateTime;

class Cycling
{
    /**
     * Handle an incoming request.
     * Check last round time
     * check number of free student
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        //return view('splash');
        /*
         * check number of fre user
         *
         */
        /*
        $user = Studentinfo::all()->where('individualStatus', 0);//get free student
        $Qsize = $user->where('QorR', 1)->count();
        $Rsize = $user->where('QorR', 0)->count();

        /*
         * check time of last round
         */
        $lastROundTime = Exam::firstorfail()->lastRound_time;
        $redisc=Redis::connection();
        $redisc.set('lastroundtime',$lastROundTime);
        $carbonlast = new Carbon($lastROundTime);
        $carbonnow = Carbon::now();


        if ((min($Qsize, $Rsize) > 20) || ($carbonlast->diffInMinutes($carbonnow) >= 5)) {

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
            $ttt = Carbon::now();
            $l->put('time', $ttt);
            $r->sadd('round', json_encode($l));


            foreach ($Rusers as $ruser) {

                $ruser->roundNumber = $nextRoundNum;
                $ruser->save();
                //   $ruser->individualStatus = 1;Todo
            }

            Event::fire(new \App\Events\checkRound($nextRoundNum));
            // Event::fire(new \App\Events\Cycling());
            return $next($request);
        }
/*
        /* whyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyy??????????????????????
         $carbonlast = new Carbon($lastROundTime);
     $carbonnow= Carbon::now('Asia/Tehran');
         return $carbonlast->diffInMinutes($carbonnow);
        */
        return $next($request);

    }
}
