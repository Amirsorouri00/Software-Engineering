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
use GuzzleHttp\client;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7;

//use Illuminate\Support\Facades\Request;

class api extends Controller
{
    // <!-- Amir Hossein -->
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    /*
     * Tested OK => Hossein
     */
    public function getEnteredPerson(Request $request)
    {

        $enteredPersonRequest = collect(['data' => ['person' => ['personalID' => '1274568', 'classID' => '1111111'],
                                    "ticket" => "volunteerRespondUserTicket"]])->toJson();
        $client = new Client();
        $data = $request['data']['person']['personalID'];
        $r = $client->request('POST', 'http://blog:81/post', ['json' => [$enteredPersonRequest]]);

        try {
            //Todo classsexam must be fix
            //$class = Classexam::where('classID', '=', $request['data']['person']['classID'])->firstOrFail();
            $class = Classexam::where('classID', '=', '1111111')->firstOrFail();

            $exam = $class->exam()->get();
            $person = new Classindividual();
            $person->personalID = $request['data']['person']['personID'];
            //$person->classID = $request['data']['person']['classID'];
            $person->isPresent = 1;
            $person->isActive = 1;

            /*
            if (Classexam::where('instructorID', '=', $request['data']['person']['personalID'])->exists()) {

                $person->accessibility = 1;
            } else {
                $person->accessibility = 0;
            }
            */
            //todo check Instructor string with enter and exit
            if ($request['data']['person']['role'] == 'Instructor') {
                $person->accessibility = 1;
            } else {
                $person->accessibility = 0;
            }
            $person->save();

            //echo $request['data']['person']['personalID'];

            //$class->member()->save($person);
            $student = new Studentinfo();
            $student->roundNumber = 0;
            $student->individualStatus = 0;
            //todo must be checked with enter exit
            $student->platform = $request['data']['person']['platform'];
            $student->finalScore = $exam->average;
            $student->save();
            $person->person()->save($student);
            //$parameter = ['stdID' => $student->participantID];
            //return redirect()->route('client', ['stdID' => $parameter]);
            return redirect()->route('client', $student->participantID);//Todo set
            // Todo send client to main.blade
            //Do stuff when user exists.
        } catch (Exception $e) {
            if (!(Classexam::where('classID', '=', $request['data']['person']['classID'])->exists())) {
                echo 'getEnteredPerson/classID not exists!';
            }
            echo $e;
            //Do stuff if it doesn't exist.
        }
    }

    public function questionPartResult(Request $request)
    {
        $b = Basket::where('basketID', 'T1cuEH0')->firstOrFail();
        $questionPartRequest = collect(['data' => ['basket' => $b], "ticket" => "volunteerRespondUserTicket"])->toJson();
        try {
            $basketOriginal = Basket::where('basketID', '=', $request['data']['basket']['basketID'])->firstOrFail();
            $responder = Studentinfo::where('participantID', '=', $basketOriginal->responderedID)->firstOrFail();
            $questioner = Studentinfo::where('participantID', '=', $basketOriginal->questionerID)->firstOrFail();
            $responderPerson = $responder->individuals();

            if ($basketOriginal->basketStatus == 'deActive' || $responderPerson->isPresent == 0) {
                //continue;
                echo 'O';
            }
            //todo check this if to run appropriatly
            else if ($request['data']['basket']['answer']['result'] == 1/* ... if responder gave wrong answer to the question */) {
                $responder->individualStatus = 1;
                $questioner->individualStatus = 1;
                $responder->save();
                $questioner->save();
                $basketOriginal->basketStatus = 'Volunteer';
                $basketOriginal->flag = 1;
                $basketOriginal->save();
                //todo must be checked if responder or questioner must be out of the game and check for cycling
                $client = new client();
                try {
                    $response = $client->post('http://software:81/l');//volunteery system
                } catch (\GuzzleHttp\Exception\ClientException $e) {
                    echo 'Caught response: ' . $e->getResponse()->getStatusCode();
                }
                // check if clients must be redirected anywhere (i guess they must be redirected in our page that they are free in it!!)
            }
            //todo
            else {
                $responder->finalScore += $basketOriginal->basketScore;
                $responder->save();
                $responder->individualStatus = 1;
                $questioner->individualStatus = 1;
                $responder->save();
                $questioner->save();
                $basketOriginal->basketStatus = 'deActive';
                $basketOriginal->save();
                //todo must be checked if clients must be out of the game and check for cycling

            }
            //Ready to send the volunteery basketID to volunteer system
            //Do stuff when user exists.
        } catch (Exception $e) {
            if (!(Basket::where('basketID', '=', $request['data']['basket']['basketID'])->exists())) {
                echo 'questionPartResult/basketID not exists!';
            }
            if (!(Studentinfo::where('participantID', '=', $basketOriginal->responderedID)->exists())) {
                echo 'questionPartResult/participantID not exists!';
            }
            return $e;
            //Do stuff if it doesn't exist.
        }

    }

    public function volunteerResult(Request $request)
    {
        $b = Basket::where('basketStatus', '=', 'volunteer')->firstOrFail();
        $questionPartVolunteerRequest = collect(['data' => [['basket' => $b], "respondentlist" => ['RS8DaLx', 'DqA02oI', 'pZu9C0T']]
            , "ticket" => "volunteerRespondUserTicket"])->toJson();
        //
        try {
            $correctResponders = array();
            $basketOriginal = Basket::where('basketID', '=', $request['data']['basket']['basketID'])->firstOrFail();
            $responder = Studentinfo::where('participantID', '=', $basketOriginal->responderedID)->firstOrFail();
            $responderPerson = $responder->individuals();
            $respondersInfo = $request['data']['respondentlist'];

            if ($basketOriginal->basketStatus == 'deActive' || $responderPerson->isPresent == 0) {
                echo 'O';
            } else {
                //echo 'e';
                $correctAnswerNumber = 0;
                foreach ($respondersInfo as $responderInfo) {
                    //return $responderInfo;
                    $responder = Studentinfo::where('participantID', '=', $responderInfo)->firstOrFail();
                    if ($responderInfo['answer']['result'] == 1 /* True answer */) {
                        $correctResponders[$correctAnswerNumber] = $responder;
                        $correctAnswerNumber++;
                    } else {
                        continue;
                    }
                }
                $basketOriginal->basketStatus = 'deActive';//todo must be checked if it works or not
                if ($correctAnswerNumber >= 0) {
                    $bonus = $basketOriginal->basketScore / $correctAnswerNumber;
                    foreach ($correctResponders as $resp) {
                        $resp->finalScore += $bonus;
                        $resp->individualStatus = 0;
                        $resp->save();
                    }
                }
                else{
                    foreach ($respondersInfo as $responderInfo) {
                        $responder = Studentinfo::where('participantID', '=', $responderInfo)->firstOrFail();
                        $responder->individualStatus = 0;
                        $responder->save();
                    }
                    try{
                        $questioner = Studentinfo::where('participantID', '=', $basketOriginal->questionerID)->firstOrFail();
                        $questioner->finalScore += Exam::all()->take(1)[0]->questionScore;
                        $questioner->save();
                        //todo check if user must be out of the game and check cycling event
                    }catch(\Exception $e){
                        //todo must be checked what that is
                    }
                }
            }
            //Do stuff when user exists.
        } catch (Exception $e) {
            return $e;
            //Do stuff if it doesn't exist.
        }
    }

    public function getObjectedToScoreBasket(Request $request)
    {
        try {
            $basketOriginal = Basket::where('basketID', '=', $request['data']['basket']['basketID'])->firstOrFail();
            $objector = Studentinfo::where('participantID', '=', $basketOriginal->responderedID)->firstOrFail();
            $objectorPerson = $objector->individuals();
            $exam = Exam::where('examID', '=', $basketOriginal->examID)->firstOrFail();
            //Do stuff when user exists.
            if ($basketOriginal->basketStatus == 'deActive' || $objectorPerson->isPresent == 0) {
                //continue;
                echo $basketOriginal->basketStatus;
                echo $objectorPerson->isPresent;
            } else {
                $objector->finalScore -= $exam->questionScore;
                //$basketOriginal->basketScore += $exam->questionScore; //todo
                $objector->save();
                //$basketOriginal->save();
                echo 'saved';
                $client = new client();
                try {
                    //todo
                    $response = $client->post('http://software:81/l'/*objectoin system url*/, $request);/*variable*/
                } catch (\GuzzleHttp\Exception\ClientException $e) {
                    //echo 'Caught response: ' . $e->getResponse()->getStatusCode();
                }
                //echo 12;
            }
        } catch (Exception $e) {
            if (!(Basket::where('basketID', '=', $request['data']['basket']['basketID'])->exists())) {
                echo 'getObjectedToScoreBasket/basketID not exists!';
            }

            if (!(Studentinfo::where('participantID', '=', $basketOriginal->responderedID)->exists())) {
                echo 'getObjectedToScoreBasket/participantID not exists!';
            }

            if (!(Exam::where('examID', '=', $basketOriginal->examID)->exists())) {
                echo 'getObjectedToScoreBasket/examID not exists!';
            }
            echo 1;
            //Do stuff if it doesn't exist.
        }
        //...
        //Ready to send to objection system
    }

    public function getObjectedToScoreBasketResult(Request $request)
    {
        $b = Basket::where('basketID', 'T1cuEH0')->firstOrFail();
        $objectionRequest = collect(['data' => [['basket' => $b], "Judge" => "accepted", "desc" => "Description",
            "ticket" => "volunteerRespondUserTicket"]])->toJson();

        try {
            $basketOriginal = Basket::where('basketID', '=', $request['data']['basket']['basketID'])->firstOrFail();
            $objector = Studentinfo::where('participantID', '=', $basketOriginal->responderedID)->firstOrFail();
            $objectorPerson = $objector->individuals();
            if (($basketOriginal->basketStatus == 'deActive' || $objectorPerson->isPresent == 0)) {
                //continue;
                echo 'O';
            } else if (($basketOriginal->basketStatus == 'Active' || $objectorPerson->isPresent == 1) && $request['Judge'] != 'accepted') {
                $basketOriginal->basketStatus = 'Volunteer';
                $basketOriginal->save();
                $volunteerRequest = collect(['data' => ['basket' => $basketOriginal, 'ticket' => 'volunteerRespondUserTicket']])->toJson();
                echo 'saved7';
                //todo free qestioner and responder

                $client = new client();
                try {
                    $response = $client->post('http://software:81/l' /*variable*/);//volunteery system
                } catch (\GuzzleHttp\Exception\ClientException $e) {
                    //echo 'Caught response: ' . $e->getResponse()->getStatusCode();
                }
            } else {
                //echo 'e';
                $objector->finalScore += $basketOriginal->basketScore;
                $objector->save();
                $basketOriginal->basketStatus = 'deActive';
                $basketOriginal->save();
                // todo free questioner and responder

                echo 'saved6';
            }
            //Ready to send the volunteery basketID to volunteer system
            //Do stuff when user exists.
        } catch (Exception $e) {
            if (!(Basket::where('basketID', '=', $request['data']['basket']['basketID'])->exists())) {
                echo 'getObjectedToScoreBasketResult/basketID not exists!';
            }

            if (!(Studentinfo::where('participantID', '=', $basketOriginal->responderedID)->exists())) {
                echo 'getObjectedToScoreBasketResult/participantID not exists!';
            }
            return 1;
            //Do stuff if it doesn't exist.
        }
        //...
    }

    /*
     * Tested OK => Hossein
     * Just Send To Soal O Javab Not OK
     */
    public function getVolunteersBasket(Request $request)
    {

        $volunteerBaskets = $request['data']['basketsArray'];
        $resultBaskets = collect();
        $counter = 0;
        foreach ($volunteerBaskets as $vBasket) {
            try {
                $basketOriginal = Basket::where('basketID', '=', $vBasket['basket']['basketID'])->firstOrFail();
                if ($basketOriginal->basketStatus == 'deActive') {
                   //todo must be checked whether if there is need to do something here
                    continue;
                }
                $volunteers = $vBasket['respondentlist'];
                $cnt = 0;
                foreach ($volunteers as $volunteer1) {
                    try {
                        $volunteerInfo = Studentinfo::where('participantID', '=', $volunteer1)->firstOrFail();
                        $volunteer = $volunteerInfo->individuals();
                        $questionerInfo = Studentinfo::where('participantID', '=', $basketOriginal->questionerID)->firstOrFail();
                        $questioner = $questionerInfo->individuals();

                        if ($volunteer->isPresent == 1 && $volunteerInfo->individualStatus  == 0) {
                            try {
                                print_r("oomad toosh");
                                $exam = Exam::where('examID', '=', $basketOriginal->examID)->firstOrFail();
                                $volunteerInfo->individualStatus = 1;
                                $volunteerInfo->finalScore -= $exam->questionScore;
                                $volunteerInfo->save();

                                //todo isfree and individual status must mean busy basket status deactive
                                //todo check whether the client must be redirected from volunteer system
                                //todo on their own or we must redirect them
                            } catch (\Exception $s) {
                                print_r('nayoomad toosh');
                                continue;
                                //Do continue if it doesn't exist.
                            }
                        }
                        else
                        {
                            print_r( "ELSE");
                            echo "else";
                        }
                        //Do stuff when user exists.
                    } catch (\Exception $e) {
                        continue;
                        //Do continue if it doesn't exist.
                    }
                }
                //Do stuff when user exists.
            } catch (\Exception $g) {
                if (!(Exam::where('examID', '=', $basketOriginal->examID)->exists())) {
                    echo 'getVolunteersBasket/examID not exists!';
                }
                continue;
                //Do continue if it doesn't exist.
            }
            $basketOriginal->basketStatus = 'volunteer';
            $basketOriginal->save();
        }

//        $b = Basket::where('basketID', $request)->firstOrFail();
//        $volunteerRequest = collect(['data' => ['basketsArray' => [[['basket' => $b], "respondentlist" => ['S8rb5pB', '7WNyPMm', 'hsuZxXJ']]
//            , [['basket' => $b], "respondentlist" => ['K3ruTLY', 'HCkfF41', 'y5d1jSs']]
//            , [['basket' => $b], "respondentlist" => ['a6cwGz0', '7rYlioA', 'SRuph0i']]]]
//            , "ticket" => "volunteerRespondUserTicket"])->toJson();
        $requestToQuestionPart = collect(['data' => $request])->toJson();
//        echo $request;
        $client = new client();
        try {
            /*
             * Soal O Javab URL
             */
            $response = $client->post('http://bit.com/testPost', ['json' => $request]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            echo 'Caught response: ' . $e->getResponse()->getStatusCode();
        }
        //Ready to send to quesion part
    }
    /*
     * Not Tested
     */
    public function volunteerExitRequest(Request $request)
    {
        //todo we must check on our own how to pass student id from the page to controller
        $student = Studentinfo::where('participantID', $request->id)->firstOrFail();
        //$classExam = $student->classes();
        $exitPersonRequest = collect(['data' => ['person' => [$student], 'classID' => '1111111'],
                                        "ticket" => "volunteerRespondUserTicket"])->toJson();
        $client = new client();
        try {
            //todo post must be checked
            $response = $client->post('http://software:81/l' /*enter exit system*/, $exitPersonRequest);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            echo 'Caught response: ' . $e->getResponse()->getStatusCode();
        }
        //ready for sending to enter and exit
    }
    /*
     * Not Tested
     */
     /*public function volunteerExitResult(Request $request)
    {
        $enteredPersonRequest = collect(['data' => [['person' => ['personalID' => '1234567', 'classID' => '1234567']],
            "ticket" => "volunteerRespondUserTicket"]])->toJson();
        try {
            if (Classindividual::where('personalID', '=', $request['data']['person']['personalID'])->exists()) {
                $user = Classindividual::where('personalID', '=', $request['data']['person']['personalID'])->firstOrFail();
                $user->isPresent = 0;
                $user->save();
            }
            //Do stuff when user exists.
        } catch (Exception $e) {
            return 1;
            //Do stuff if it doesn't exist.
        }
    }*/

    /*
     * Not Tested
     */
    public function userForceExit(Request $request, Classindividual $person)
    {
        //todo must write code for sending user into this function and redirect him to exit
        $person->isPresent = 0;
        $person->save();
        $userForceExitRequest = collect(['data' => [['person' => ['personalID' => $person->personalID, 'classID' => '1111111']],
            "ticket" => "volunteerRespondUserTicket"]])->toJson();
        $client = new client();
        try {
            //todo post must be checked
            $response = $client->post('http://software:81/l' /*force exit*/, ['data' => [['person'=>
                    ['personalID' => $person->personalID, 'classID' => '1111111']]
                    ,"ticket" => "volunteerRespondUserTicket"]]);
        } catch (\Exception $e) {
        }
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