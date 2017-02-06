<?php

namespace App\Http\Controllers;

use App\Basket;
use App\Classindividual;
use App\Http\Controllers\Controller;
use App\Http\Middleware\VerifyCsrfToken;
use App\Studentinfo;
use Illuminate\Http\Request;


use App\Http\Requests;
use Mockery\CountValidator\Exception;

class Teachercontroller extends Controller
{
    public function __construct()
    {
        //$this->middleware(VerifyCsrfToken::class);
        //verify with csrf
        //verify the teacher
    }

    /**
     * Show baskets to teacher
     * @return view blade file of basket
     */

     public function login(Request $request)
     {

         /*
          * create teacher in classindividuals
          */
         $studentinfos = Studentinfo::all();
         foreach($studentinfos as $studentinfo){
             try{
                 $studentinfo = Classindividual::where('accessibility', '=', 1)->firstOrFail();
                 if(Studentinfo::where('participantID', '=', $studentinfo->personalID)->exists()) {
                     $api = new \App\Http\Controllers\api();
                
                     return view('teacher.teacherMain', ['id' => $studentinfo->personalID, 'info' =>
                           $api->attributes($studentinfo->personalID)]);
                 }
             }catch(\Exception $e){
                 continue;
             }
         }
         //return view('teacher.teacherMain', ['id' => $studentinfo->personalID]);
     }

    public function getbasketsview()
    {
        $baskets = Basket::paginate(10);
        return view('teacher.baskets', ['baskets' => $baskets]);
    }

    public function getbasket(Request $request, Basket $basket)
    {
        return view('Teacher.basket', ['basket' => $basket]);//basketview
    }

    public function basketupdate(Request $request, Basket $basket)
    {
        /*
         * update $basket
         */
        $basket->basketScore = $request->score;//:D
        $basket->save();
        $baskets = Basket::paginate(10);
        return view('teacher.baskets', ['baskets' => $baskets]);
    }

    /**
     *
     */
    public function enterround(Request $request)
    {
        $user = Classindividual::where('accessibility', 1)->firstorfail();

        try {
            $teacherStudentinfo = new Studentinfo();
            $teacherStudentinfo->individuals($user);
            $teacherStudentinfo->examID = 'examID';
            $teacherStudentinfo->QorR = 1;
            $teacherStudentinfo->individualstatus = 0;
            $teacherStudentinfo->save();
        } catch (Exception $e) {
            Debugbar::addException($e);
        }

        return redirect('/teacherlogin');  //??????????????
    }



    public function teacherEntertoGame(Request $request, Studentinfo $studentinfo){
        //dd('amir');
        $studentinfo->individualStatus = 0;
        $studentinfo->save();
        //dd($studentinfo, 'there');
        //return view('teacher.teacherStart', ['id' => $studentinfo->participantID]);
        return redirect('/teacherlogin');
    }
}
