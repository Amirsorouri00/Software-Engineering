<?php

namespace App\Events;

use App\Classindividual;
use App\Events\Event;
use App\Studentinfo;
use App\Basket;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Storage;

class Cycling extends Event
{
    use SerializesModels;

    /**
     * Create a new event instance.
     *
     * @return void
     */

    public $list;
    public $roundnimber;
    public function __construct($num)
    {
        $this->roundnimber=$num;
        $QRarray= $this->matchwithperiod();
        $this->list= $this->listofbasket($QRarray);
        return redirect('test');
    }


    /**
     * create array of questioner and respondent
     *
     */
    public function matchwithperiod()
    {
        $user = Studentinfo::all()->where('individualStatus', 0)->where('roundnumber',$this->roundnimber);//get free student
        $Qsize=$user->where('QorR', 1)->count();
        $Rsize = $user->where('QorR', 0)->count();

        if($Qsize>$Rsize)
        {
            $questioner = $user->where('QorR', 1)->take($Rsize);
            $respondent = $user->where('QorR', 0)->take($Rsize);
        }else
        {
            $questioner = $user->where('QorR', 1)->take($Qsize);
            $respondent = $user->where('QorR', 0)->take($Qsize);
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
            $f = $q['gradeL'];
            $c = $q['gradeH'];
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

        $list=collect();
        foreach($QRarray as $tem)
        {
            $ClassIidQ= $tem['questioner']->participantID;
            $ClassIQ= Classindividual::where('personalID',$ClassIidQ)->first();

            //dd($ClassIQ);
            // dd ($tem['questioner']->participants()->first());//whyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyyy
            $ClassIR = $tem['respondent']->participantID;
            $ClassIR = Classindividual::where('personalID',$ClassIR)->first();

            // dd($ClassIR);
            $basket = new Basket;
            $basket->basketID=str_random(7);
            $basket->save();
            $ClassIQ->Qbasket()->save($basket);
            $ClassIR->Rbasket()->save($basket);
            $list->push($basket);
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
