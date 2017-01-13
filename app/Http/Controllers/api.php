<?php
/**
 * Created by PhpStorm.
 * User: hkafi
 * Date: 12/25/2016
 * Time: 12:29 AM
 */

namespace App\Http\Controllers;

use App\Classexam;
use App\Classindividual;
use App\Exam;
use App\Http\Controllers\amircontroller;
//use App\Http\Requests\Request;
use App\Studentinfo;
use App\User;
use App\Basket;
use Exception;
use Symfony\Component\HttpFoundation\ParameterBag;
use Illuminate\Http\Request;
use App\Http\Requests;

//use Illuminate\Support\Facades\Request;

class api extends Controller
{
    // <!-- Amir Hossein -->
    public function getVolunteersBasket(Request $request)
    {
        $volunteerRequest = collect(['data' => ['basketsArray' => [['basket' => '9NdHh6W', "respondentlist" => ['F7h1fKc', 't8jGhxy', '1LIntOW']]
            , ['basket' => 'tUefAHC', "respondentlist" => ['pUKhuzB', 'GzjheJm', 'ONOtLqF']]
            , ['basket' => '05ZhVH6', "respondentlist" => ['f7YiyhT', '8wkY9HX', 'SqrIY3M']]],
            "ticket" => "volunteerRespondUserTicket"]])->toJson();
        $decode = json_decode($request, true);
        //return $request;
        //return $decode;
        $volunteerBaskets = $request['data']['basketsArray'];
        //return $volunteerBaskets;
        $resultBaskets = collect();
        foreach ($volunteerBaskets as $vBasket) {
            //return $vBasket;
            try {
                $basketOriginal = Basket::where('basketID', '=', $vBasket['basket'])->firstOrFail();
                //Do stuff when user exists.
            } catch (ErrorException $e) {
                continue;
                //Do stuff if it doesn't exist.
            }
            if ($basketOriginal->basketStatus == 'deActive') {
                //continue;
            }
            $volunteers = $vBasket['respondentlist'];
            foreach ($volunteers as $volunteer) {
                try {
                    $volunteerInfo = Studentinfo::where('participantID', '=', $volunteer)->firstOrFail();
                    $volunteer = $volunteerInfo->individuals();
                    //Do stuff when user exists.
                } catch (ErrorException $e) {
                    continue;
                    //Do stuff if it doesn't exist.
                }
                if ($volunteer->isPresent == 1 && $volunteerInfo->individualStatus) {
                    //$exam = Exam::where('examID', '=', $basketOriginal->examID)->firstOrFail();
                    $basket = new Basket();
                    $basket->basketID = str_random(7);
                    $basket->questionID = $basketOriginal->questionID;
                    $basket->basketStatus = 'Active';
                    $basket->basketScore = $basketOriginal->basketScore;
                    $basket->flag = 1;
                    $basket->save();
                    //$exam->basket()->save($basket);
                    $volunteer->Rbasket()->save($basket);
                    $volunteerInfo->individualStatus = false;
                    $volunteerInfo->save();
                    $resultBaskets->push($basket);
                }
            }
            $basketOriginal->basketStatus = 'deActive';
            $basketOriginal->save();
        }
        $requestToQuestionPart = collect(['data' => ['basket' => $resultBaskets]])->toJson();
        return $requestToQuestionPart;
        //...
        //Ready to send to quesion part
    }

    public function getObjectedToScoreBasket(Request $request)
    {
        $objectionRequest = collect(['data' => [['basket' => '9NdHh6W'], "ticket" => "volunteerRespondUserTicket"]])->toJson();
        //return $objectionRequest;
        //return $request['data']['basket'];
        try {
            $basketOriginal = Basket::where('basketID', '=', $request['data']['basket'])->firstOrFail();
            //$exam = Exam::where('examID', '=', $basketOriginal->examID)->firstOrFail();
            //return $basketOriginal;
            $objector = Studentinfo::where('participantID', '=', $basketOriginal->responderedID)->firstOrFail();
            return $objector;
            $objectorPerson = $objector->individuals();
            //Do stuff when user exists.
        } catch (\Exception $e) {
            return 1;
            //Do stuff if it doesn't exist.
        }
        if ($basketOriginal->basketStatus == 'deActive' || $objectorPerson->isPresent == 0) {
            //continue;
            return 11;
        } else {
            $objector->finalScore -= $exam->questionScore;
            $basketOriginal->basketScore += $exam->questionScore;
            $objector->save();
            return 12;
        }
        //...
        //Ready to send to objection system
    }

    public function getObjectedToScoreBasketResult(Request $request)
    {
        $objectionRequest = collect(['data' => [['basket' => '9NdHh6W'], "Judge" => "accepted", "desc" => "Description",
            "ticket" => "volunteerRespondUserTicket"]])->toJson();
        try {
            $basketOriginal = Basket::where('basketID', '=', $request['data']['basket'])->firstOrFail();
            //$exam = Exam::where('examID', '=', $basketOriginal->examID)->firstOrFail();
            $objector = Studentinfo::where('participantID', '=', $basketOriginal->responderedID)->firstOrFail();
            $objectorPerson = $objector->individuals();
            //Do stuff when user exists.
        } catch (ErrorException $e) {
            return null;
            //Do stuff if it doesn't exist.
        }
        if ($basketOriginal->basketStatus == 'deActive' || $objectorPerson->isPresent == 0) {
            //continue;
        } else {
            $objector->finalScore += $basketOriginal->basketScore;
            $objector->save();
            $basketOriginal->basketStatus = 'Volunteer';
        }
        //...
        //Ready to send the volunteery basketID to volunteer system
    }

    public function getEnteredPerson(Request $request)
    {
        $enteredPersonRequest = collect(['data' => [['person' => ['personalID' => '1234567', 'classID' => '1234567']],
            "ticket" => "volunteerRespondUserTicket"]])->toJson();
        //return $request;
        try {
            //return $request['data']['person']['classID'];
            $class = Classexam::where('classID', '=', $request['data']['person']['classID'])->firstOrFail();
            //Do stuff when user exists.
        } catch (ErrorException $e) {
            return null;
            //Do stuff if it doesn't exist.
        }
        $person = new Classindividual();
        $person->personalID = $request['data']['person']['personalID'];
        //$person->classID = $enteredPersonRequest['data']['person']['classID'];
        $person->isPresent = 1;
        $person->isActive = 1;
        if (Classexam::where('instructorID', '=', $request['data']['person']['personalID'])->exists()) {
            $person->accessibility = 1;
        } else {
            $person->accessibility = 0;
        }
        $person->save();
        $class->classindividual()->save($person);
        $student = new Studentinfo();
        $student->roundNumber = 0;
        $student->individualStatus = true;
        //$student->finalScore = $exam->average;
        $student->save();
        $person->person()->save($student);
    }

    public function volunteerExitRequest(Request $request)
    {
        $user = $request->user();
        $classExam = $user->classes();
        $enteredPersonRequest = collect(['data' => [['person' => ['personalID' => $user->personalID, 'classID' => $classExam->classID]],
            "ticket" => "volunteerRespondUserTicket"]])->toJson();
        //ready for sending to enter and exit
    }

    public function volunteerExitResult(Request $request)
    {
        $enteredPersonRequest = collect(['data' => [['person' => ['personalID' => '1234567', 'classID' => '1234567']],
            "ticket" => "volunteerRespondUserTicket"]])->toJson();
        if (Classindividual::where('personalID', '=', $request['data']['person']['personalID'])->exists()) {
            $user = Classindividual::where('personalID', '=', $request['data']['person']['personalID'])->firstOrFail();
            $user->isPresent = 0;
            $user->save();
        }
    }

    public function userForceExit(Request $request, Classindividual $person)
    {
        $classExam = $person->classes();
        $person->isPresent = 0;
        $person->save();
        $userForceExitRequest = collect(['data' => [['person' => ['personalID' => $person->personalID, 'classID' => $classExam->classID]],
            "ticket" => "volunteerRespondUserTicket"]])->toJson();
        //ready for sending to enter and exit system
    }

    // <!-- /Amir Hossein -->

    public function volunteer(Request $request)
    {
        $jj = json_decode($request);

        $rr = $request->json();
        $basket = new Basket();
        $basket->basketID = $rr->all()['data']['basket']['basketID'];
        $basket->examID = $rr->all()['data']['basket']['examID'];
        $basket->questionerID = $rr->all()['data']['basket']['questionerID'];
        $basket->responderedID = $rr->all()['data']['basket']['responderedID'];
        $basket->basketScore = $rr->all()['data']['basket']['basketScore'];
        //$basket-> participantID = $rr-> all()['data']['person']['participantID'];
        $basket->save();
        dd($jj);

        /*
         * post to volunteer server
         * send volunteer Users to volunteer server
         */
        $volunteerSendUser = collect(['data' => ['userlist' => [1, 2, 3]], 'ticket' => 'volunteerSendUserTicket']);

        /*
         * Response from volunteer server
         * get baskets with list of responders
        */
        $volunteerRespondUser = collect(['data' => ['basketsArray' => [['basket' => 'bjson', 'respondentlist' => [1, 2, 3]], ['basket' => 'bjson', 'respondentlist' => [1, 2, 3]]]], 'ticket' => 'volunteerrespondUserTicket']);

        /*
         * post to volunteer server
         * send unSolved basket to volunteer server
         * send to questioner server !!!
         */
        $volunteerSendBasketsWithUsers = collect(['data' => ['basketsArray' => [['basket' => 'bjson'], ['basket' => 'bjson']]], 'ticket' => 'volunteerSendBasketsWithUsersTicket']);


        /*
         * post to volunteer server
         * send basket that unSolved to volunteer server
         */
        $volunteerSendUnSolvedBasket = collect(['data' => ['unResolvedBasket' => 'bJson'], 'ticket' => 'volunteerSendUnSolvedBasketTicket']);

        return response()->json($volunteerRespondUser);
        return $volunteerSendUnSolvedBasket->toJson();
        //  $baskets = json_decode($request->baskets);
        $f = Studentinfo::find(1);
        $f->reduceGrade(2);
        foreach (user as $baskets->user) {
            /*
             *reduce grade from volunteer users
             * */
        }
        foreach (basket as $baskets) {
            sendToAnswerQuestionPart(basket);
        }
    }

    public function Judge()
    {

        /*
         * post to judge server
         * send basket to judge
         */
        $sendToJudge = collect(['data' => ['basket' => 'bJson'], 'thicket' => 'sendToObjectedTicket']);

        /*
         * api for get result of judging
         */
        $getAnswerFromJudge = collect(['data' => ['basket' => 'bJson', 'Judge' => 'accepted', 'desc' => 'Description']]);

        return $getAnswerFromJudge->toJson();
    }

    public function EnterAndExit(Request $request)
    {
        //   $rr= $request->json();
        //  dd($rr->all()['data']['basketsArray'][0]['basket']);
        // $request = Request::instance()->getContent();
        //dd($request);
//        return $request;
        if ($request->isjson()) {
            return 1;
        }
        $jj = json_decode($request);

        $rr = $request->json();
        $user = new Studentinfo();
        $user->examID = $rr->all()['data']['person']['examID'];
        $user->participantID = $rr->all()['data']['person']['participantID'];
        $user->save();

        dd($jj);

        return $request->json()->all()[data];
        return $jj->data;
        return response()->json($request);

        return response()->json($request);
        $h = new User();

        /*
         * api for get student to Start Exam Game
         */
        $getEnterStudent = collect(['data' => ['person' => 'SJson'], 'ticket' => 'EnterUserTicket']);


        /*
         * api for get Student to Exit From Game
         */

        $getExitStudent = collect(['data' => ['person' => 'SJson'], 'ticket' => 'ExitUserTicket']);

        /*
         *send users for force exit
         */
        $sendForceExitStudentToEnterAndExitPart = collect(['data' => ['persons' => ['person' => 'SJson']], 'ticket' => 'ForceExitTicket']);

        return $sendForceExitStudentToEnterAndExitPart->toJson();
    }

    public function questionPlatform()
    {

    }
}