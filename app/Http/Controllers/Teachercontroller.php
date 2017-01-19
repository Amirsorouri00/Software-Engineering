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

        //   $this->middleware(VerifyCsrfToken::class);
        //verify with csrf
        //verify the teacher
    }

    /**
     * Show baskets to teacher
     * @return view blade file of basket
     */
    public function getbasketsview()
    {

        $baskets = Basket::paginate(15);
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
        return 1;
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

        //return redirect()  //??????????????
    }

    public function login(Request $request)
    {
        $teacherClass = new Classindividual();

        $teacherClass->accessibility = 1;
        $teacherClass->classID = 'sdfsd';
        $teacherClass->personalID = 'sdfa';
        $teacherClass->save();
$teacherStudent= new Studentinfo();
        $teacherStudent->individuals()->save($teacherClass);
        $teacherClass->save();
        /*
         * create teacher in classindividuals
         */
        return view('teacher.teacherpage');
    }

}
