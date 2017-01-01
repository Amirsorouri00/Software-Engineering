<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Carbon;
use App\Task;
use App\Basket;
use App\Randomnumber;
use App\Studentinfo;
use App\Exam;
use App\Classindividual;
use App\Classexam;
use App\Repositories\TaskRepository;

class amircontroller extends Controller
{

    public function test(Request $request)
    {

        /*
        // Add Basket
        $basket = new Basket;
        $basket->basketID = '1234589';
        $basket->questionID = '1234567';
        $basket->basketScore = 1;
        $basket->basketStatus = 'active';
        $exam = Exam::where('lessonGroup', '=' , 'it')->firstOrFail();
        $questioner = Classindividual::where('personalID', '=', '1234567')->firstOrFail();
        //dd($questioner);
        $responder = Classindividual::where('personalID', '=', '2345678')->firstOrFail();
        //dd($responder);
        $questioner->Qbasket()->save($basket);
        $responder->Rbasket()->save($basket);
        $exam->basket()->save($basket);
        $basket->save();
        dd($basket);
        dd($exam);
        */

        /*
        // Add Exam
        $exam = new Exam;
        $exam->examID = '4567892';
        $exam->lessonGroup = 'software';
        $ins = Classindividual::where('personalID', '=', '2345678')->firstOrFail();
        $ins->insexam()->save($exam);
        $exam->save();
        dd($ins);
        */

        /*
        // Add Studentinfo
        $student = new Studentinfo;
        $participant = Classindividual::where('personalID', '=', '1234567')->firstOrFail();
        $exam = Exam::where('lessonGroup', '=' , 'hardware')->firstOrFail();
        $participant->person()->save($student);
        $exam->student()->save($student);
        $student->save();
        //participant id must be unique
        */

    }

    public function cycle(Request $request)
    {
        $freeStdNum = Studentinfo::where('individualStatus', '=', 'false')->count();
        //dd($freeStd);
        if ($freeStdNum <= 10) {
            $freeStd = Studentinfo::where('individualStatus', '=', 'false')->get();

            $responders = DB::table('studentinfos')
                ->select(DB::raw('*'))
                ->whereRaw('roundNumber%2 = 1')
                ->get();
            $questioners = DB::table('studentinfos')
                ->select(DB::raw('*'))
                ->whereRaw('roundNumber%2 = 0')
                ->get();
//        dd($responders);
//        dd($questioners);
        } else {
            # code...
        }
    }


    public function matchwithrandom()
    {
        $user = User::all()->where('isfree', '1');
        $questioner = $user->where('questioner', 1)->take(20);
        $respondent = $user->where('questioner', 0)->take(20);
        $questioner = $questioner->shuffle();
        $respondent = $respondent->shuffle();
        $res = collect();
        while ($questioner->isNotEmpty()) {
            $q = $questioner->shift();
            $r = $respondent->shift();
            $temp = collect(['questioner' => $q, 'respondent' => $r]);
            $res->push($temp);

        }
        dd($res);

    }

    public function matchwithperiod()
    {

        /*
            $user = User::all()->where('isfree', '1');
            $questioner = $user->where('questioner', 1)->take(20);
            $respondent = $user->where('questioner', 0)->take(20);

            $sorted = $questioner->sortBy(function ($product, $key) {
              return $product['ceiling'] - $product['floor'];
            });
        */
        $res = collect();
        $sorted = $sorted->values();
        foreach ($sorted as $q) {
            $f = $q['floor'];
            $c = $q['ceiling'];

            foreach ($respondent as $r) {
                if ($r['grade'] < $c && $r['grade'] > $f) {
                    $resp = $respondent->pull($respondent->search($r));
                    //dd($resp);
                    $temp = collect(['questioner' => $q, 'respondent' => $resp]);
                    $res->push($temp);
                    $sorted->pull($sorted->search($q));
                    break;
                }

            }
        }
        foreach ($sorted as $s) {
            $f = $s['floor'];
            $c = $s['ceiling'];
            $min = 100;

            foreach ($respondent as $r) {

                $rGrade = $r['grade'];
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
        // dd($sorted);
        return $res;

    }
}


