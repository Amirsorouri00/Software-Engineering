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

  public function test(Request $request)  {

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

    public function cycle(Request $request){
      $freeStdNum = Studentinfo::where('individualStatus', '=', 'false')->count();
      //dd($freeStd);
      if($freeStdNum <= 10){
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
      }
      else {
        # code...
      }
    }
}
