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
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $user = Studentinfo::all()->where('individualStatus', 0);//get free student
        $Qsize=$user->where('QorR', 1)->count();
        $Rsize = $user->where('QorR', 0)->count();
    /*  if(min($Qsize,$Rsize)>20)
        {
            //fire start round
            return $next($request);
        }

*/

$lastROundTime= Exam::firstorfail()->lastRound_time;

       /* whyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyy??????????????????????
        $carbonlast = new Carbon($lastROundTime);
    $carbonnow= Carbon::now('Asia/Tehran');
        return $carbonlast->diffInMinutes($carbonnow);
       */

        $carbonlast = new Carbon($lastROundTime);
        $carbonnow= Carbon::now();

       if ($carbonlast->diffInMinutes($carbonnow)>=5)
       {
           Event::fire(new \App\Events\Cycling());

           return 1;
           return $next($request);
       }

    }
}
