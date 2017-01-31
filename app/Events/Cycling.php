<?php

namespace App\Events;

use App\Classindividual;
use App\Events\Event;
use App\Exam;
use App\Studentinfo;
use App\Basket;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Storage;
use Redis;

class Cycling extends Event
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public $list;

    public $roundnumberInd;

    public function __construct($num)
    {
        $this->roundnumberInd = $num;
      //  $redis =Redis::connection();
      //  $redis->publish('log',$this->roundnumberInd);
        $QRarray = $this->matchwithperiod();
        $this->list = $this->listofbasket($QRarray);
        // return redirect('test');
    }


    /**
     * create array of questioner and respondent
     *
     */
    public function matchwithperiod()
    {

        $user = Studentinfo::all()->where('roundNumberInd', (int)$this->roundnumberInd);
        //get free student

        $Qsize = $user->where('QorR', 1)->count();
        $Rsize = $user->where('QorR', 0)->count();

        if ($Qsize > $Rsize) {
            $questioner = $user->where('QorR', 1)->take($Rsize);
            $respondent = $user->where('QorR', 0)->take($Rsize);
        } else {
            $questioner = $user->where('QorR', 1)->take($Qsize);
            $respondent = $user->where('QorR', 0)->take($Qsize);
        }
        foreach ($questioner as $qr) {
            $qr->QorR = 0;
            $qr->save();

        }
        foreach ($respondent as $qr) {
            $qr->QorR = 1;
            $qr->save();

        }

        $questioner = $questioner->shuffle();
        $respondent = $respondent->shuffle();
        $sorted = $questioner->sortBy(function ($product, $key) {
            return $product['gradeH'] - $product['gradeL'];
        });


        $res = collect();
        $sorted = $sorted->values();

        foreach ($sorted as $q) {
            $f = $q['gradeL'];
            $c = $q['gradeH'];

            foreach ($respondent as $r) {
                if ($r['finalScore'] < $c && $r['finalScore'] > $f) {
                    $resp = $respondent->pull($respondent->search($r));

                    $temp = collect(['questioner' => $q, 'respondent' => $resp]);
                    $res->push($temp);
                    $sorted->pull($sorted->search($q));
                    break;
                }
            }
        }

        foreach ($sorted as $s) {
            $f = $s['gradeL'];
            $c = $s['gradeH'];
            $min = 100;

            foreach ($respondent as $r) {

                $rGrade = $r['finalScore'];
                $diff = abs($f - $rGrade);
                $difc = abs($c - $rGrade);
                if ($difc < $min) {
                    $min = $diff;
                    $resres = $r;
                } else if ($diff < $min) {
                    $min = $difc;
                    $resres = $r;
                }
            }


            $resp = $respondent->pull($respondent->search($resres));
            //dd($resp);
            $temp = collect(['questioner' => $s, 'respondent' => $resp]);
            $res->push($temp);
            $sorted->pull($sorted->search($s));
        }
        return $res;
    }

    /**
     * @param $QRarray
     */
    public function listofbasket($QRarray)
    {

        $list = collect();
        foreach ($QRarray as $tem) {
            $ClassIidQ = $tem['questioner']->participantID;
            $ClassIQ = Classindividual::where('personalID', $ClassIidQ)->first();

            //dd($ClassIQ);
            // dd ($tem['questioner']->participants()->first());//whyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyy
            $ClassIR = $tem['respondent']->participantID;
            $ClassIR = Classindividual::where('personalID', $ClassIR)->first();

            // dd($ClassIR);
            $scoreExam = Exam::all()->first()->questionScore;
            $basket = new Basket;
            $basket->basketID = str_random(7);

            $basket->qPlatform = $tem['questioner']->platform;
            $tem['questioner']->finalScore = $tem['questioner']->finalScore - $scoreExam;
            $tem['respondent']->finalScore = $tem['respondent']->finalScore - $scoreExam;
            $tem['questioner']->save();
            $tem['respondent']->save();
            $basket->rPlatform = $tem['respondent']->platform;

            $basket->basketScore = 2;
            $basket->basketStatus = 'Active';
            $basket->flag = 0;

            $basket->save();
            $ClassIQ->Qbasket()->save($basket);
            $ClassIR->Rbasket()->save($basket);
            $temp = collect();
            $temp->put('basket', $basket);
            $list->push($temp);
        }
        //return redirect('/test');
        return $list;
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
