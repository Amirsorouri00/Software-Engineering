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
//use Illuminate\Support\Facades\Request;

class api extends Controller
{
    // <!-- Amir Hossein -->
    public function getEnteredPerson(Request $request){
        $enteredPersonRequest = collect(['data' => ['person' => ['personalID' => '1274568', 'classID' => '7HhRE7U'],
            "ticket" => "volunteerRespondUserTicket"]])->toJson();
        //return $enteredPersonRequest;
        //$request = json_encode($req);
        //print($request->getContent());
        //echo 'lkjhlkhklh';
        //return redirect('/test');
        //$client = new Client();
        //$response = $client->get('software:81/test');
        //print_r($response);
        //print_r($request);
        //print_r($request['data']);
        //print $request;
        //print 'amirasdfasdf';
        //$req = json
        //_encode($request);
        //$u = \GuzzleHttp\json_decode($request,true);
        //echo $u['data'];
        //$u = $request;
        //echo $u;
        //return $request['data'];
        try {
            $class = Classexam::where('classID', '=', $request['data']['person']['classID'])->firstOrFail();
            $exam = $class->exam()->get();
            $person = new Classindividual();
            $person->personalID = $request['data']['person']['personalID'];
            //$person->classID = $request['data']['person']['classID'];
            $person->isPresent = 1;
            $person->isActive = 1;

            if(Classexam::where('instructorID', '=', $request['data']['person']['personalID'])->exists()){
                $person->accessibility = 1;
            }
            else{
                $person->accessibility = 0;
            }
            $person->save();
            echo $request['data']['person']['personalID'];
            //$class->member()->save($person);
            $student = new Studentinfo();
            $student->roundNumber = 0;
            $student->individualStatus = true;
            //$student->finalScore = $exam->average;
            $student->save();
            $person->person()->save($student);
            echo 'alan';
            //return $exam;
            $parameter = ['stdID' => $student->participantID];
            //return redirect()->route('client', ['stdID' => $parameter]);
            return redirect()->route('client', $student->participantID);
            //Do stuff when user exists.
        } catch (Exception $e) {
            echo $e;
            //Do stuff if it doesn't exist.
        }

        //echo $person;
        //echo $student;
    }

    public function questionPartResult(Request $request){
        //$b = Basket::where('basketID', 'T1cuEH0')->firstOrFail();
        //$questionPartRequest = collect(['data' => ['basket' => $b], "ticket" => "volunteerRespondUserTicket"])->toJson();
        //echo $request;
        //return 1;
        try {
            $basketOriginal = Basket::where('basketID', '=', $request['data']['basket']['basketID'])->firstOrFail();
            $responder = Studentinfo::where('participantID', '=', $basketOriginal->responderedID)->firstOrFail();
            $responderPerson = $responder->individuals();
            //echo $request['data']['data'];
            //echo 'O';
            //return $request['data']['basket'];
            if($basketOriginal->basketStatus == 'deActive' || $responderPerson->isPresent == 0) {
                //continue;
                echo 'O';
            }
            else{
                //echo 'e';
                $responder->finalScore += $basketOriginal->basketScore;
                $responder->save();
                $basketOriginal->basketStatus = 'deActive';
                $basketOriginal->save();
                echo 'saved';
            }
            //$volunteerRequest = collect(['data' => [['basket' => $b], 'ticket' => 'volunteerRespondUserTicket']])->toJson();
            //echo $volunteerRequest;
           /* $client = new client();
            try {
                $response = $client->post('http://software:81/l' );//volunteery system
            } catch (\GuzzleHttp\Exception\ClientException $e) {
                echo 'Caught response: ' . $e->getResponse()->getStatusCode();
            }*/
            //Ready to send the volunteery basketID to volunteer system
            //Do stuff when user exists.
        } catch (Exception $e) {
            return 1;
            //Do stuff if it doesn't exist.
        }

    }

    public function getObjectedToScoreBasket(Request $request){
        //$b = Basket::where('basketID', 'T1cuEH0')->firstOrFail();
        //$objectionRequest = collect(['data' => ['basket' => $b], "ticket" => "volunteerRespondUserTicket"])->toJson();

        echo $request['data']['basket']['basketID'];
        //return 1;

        //return $request['data']['basket']['basketID'];
        //return $request['data']['basket'];
        try {
            $basketOriginal = Basket::where('basketID', '=', $request['data']['basket']['basketID'])->firstOrFail();
            //echo $basketOriginal->responderedID;
            //echo 'beforeobjector';
            $objector = Studentinfo::where('participantID', '=', $basketOriginal->responderedID)->firstOrFail();
            //$objector = $basketOriginal->responder()->get();

            //return $objector;
            //echo 'objector';
            //return $objector;
            $objectorPerson = $objector->individuals();
            //$objectorPerson = $objector;
            //$objector = $objectorPerson->person()->get();
            //return  $objector;
            //echo 'objectorperson';
            $exam = Exam::where('examID', '=', $basketOriginal->examID)->firstOrFail();
            //echo 'exam';
            //return $basketOriginal;
            //Do stuff when user exists.
            if($basketOriginal->basketStatus == 'deActive' || $objectorPerson->isPresent == 0){
                //continue;
                echo $basketOriginal->basketStatus;
                echo $objectorPerson->isPresent;
            }else{
                //echo 'else';
                $objector->finalScore -= $exam->questionScore;
                //echo 'else1';
                $basketOriginal->basketScore += $exam->questionScore;
                //echo 'else2';
                $objector->save();
                $basketOriginal->save();
                echo 'saved';
                $client = new client();
                try {
                    $response = $client->post('http://software:81/l'/*objectoin system url*/, $request);
                } catch (\GuzzleHttp\Exception\ClientException $e) {
                    //echo 'Caught response: ' . $e->getResponse()->getStatusCode();
                }
                //echo 12;
            }
        } catch (Exception $e) {
            echo 1;
            //Do stuff if it doesn't exist.
        }
        //...
        //Ready to send to objection system
    }

    public function getObjectedToScoreBasketResult(Request $request){
        //$b = Basket::where('basketID', 'T1cuEH0')->firstOrFail();
        /*$objectionRequest = collect(['data' => [['basket' => $b], "Judge" => "accepted", "desc" => "Description",
            "ticket" => "volunteerRespondUserTicket"]])->toJson();*/
        //echo $request;
        //return 1;
        //return $request;
        try {
            $basketOriginal = Basket::where('basketID', '=', $request['data']['basket']['basketID'])->firstOrFail();
            $objector = Studentinfo::where('participantID', '=', $basketOriginal->responderedID)->firstOrFail();
            $objectorPerson = $objector->individuals();
            //echo $request['data']['data'];
            //echo 'O';
            //return $request['data']['basket'];
            if(($basketOriginal->basketStatus == 'deActive' || $objectorPerson->isPresent == 0)) {
                //continue;
                echo 'O';
            }
            else if(($basketOriginal->basketStatus == 'Active' || $objectorPerson->isPresent == 1) && $request['Judge'] != 'accepted'){
                $basketOriginal->basketStatus = 'Volunteer';
                $basketOriginal->save();
                $volunteerRequest = collect(['data' => ['basket' => $basketOriginal, 'ticket' => 'volunteerRespondUserTicket']])->toJson();
                echo 'saved7';
                /*
            $client = new client();
            try {
                $response = $client->post('http://software:81/l' );//volunteery system
            } catch (\GuzzleHttp\Exception\ClientException $e) {
                //echo 'Caught response: ' . $e->getResponse()->getStatusCode();
            }*/
            }
            else{
                //echo 'e';
                $objector->finalScore += $basketOriginal->basketScore;
                $objector->save();
                $basketOriginal->basketStatus = 'deActive';
                $basketOriginal->save();
                echo 'saved6';
            }

            //Ready to send the volunteery basketID to volunteer system
            //Do stuff when user exists.
        } catch (Exception $e) {
            return 1;
            //Do stuff if it doesn't exist.
        }
        //...
    }

    public function getVolunteersBasket(Request $request){
        //$b = Basket::where('basketID', 'T1cuEH0')->firstOrFail();
        /*$volunteerRequest = collect(['data' => ['basketsArray' => [[['basket' => $b],"respondentlist"=> ['S8rb5pB','7WNyPMm','hsuZxXJ']]
                                        ,[['basket' => $b],"respondentlist"=> ['K3ruTLY','HCkfF41','y5d1jSs']]
                                        ,[['basket' => $b],"respondentlist"=> ['a6cwGz0','7rYlioA','SRuph0i']]]]
                                        ,"ticket" => "volunteerRespondUserTicket"])->toJson();*/
        //$decode = json_decode($request, true);
        //return $request;
        //return $volunteerRequest;
        //return $decode;
        //$request = json_encode($req);
        //return $volunteerRequest;
        //echo 'sadfasdfa';
        //print 'asdfasd';
        //echo $request['data']['basketsArray'];
        //print json_encode($request['data']['basketsArray']);
        //print_r($request['data']['basketsArray']);
        //return 1;
        $volunteerBaskets = $request['data']['basketsArray'];
        //echo $volunteerBaskets[];
        //return $volunteerBaskets;
        $resultBaskets = collect();
        $counter = 0;
        foreach($volunteerBaskets as $vBasket){
            //echo $vBasket['basket']['basketID'];
            //return $vBasket;
            try {
                $basketOriginal = Basket::where('basketID', '=', $vBasket['basket']['basketID'])->firstOrFail();
                if($basketOriginal->basketStatus == 'deActive'){
                    echo $counter++;
                    continue;
                }
                //echo $basketOriginal;
                $volunteers = $vBasket['respondentlist'];
                $cnt = 0;
                foreach($volunteers as $volunteer1){
                    try {
                        echo '1';
                        $volunteerInfo = Studentinfo::where('participantID', '=', $volunteer1)->firstOrFail();
                        echo '2';
                        $volunteer = $volunteerInfo->individuals();
                        echo '3';
                        $questionerInfo = Studentinfo::where('participantID', '=', $basketOriginal->questionerID)->firstOrFail();
                        echo '4';
                        $questioner = $questionerInfo->individuals();
                        echo '5';
                        if($volunteer->isPresent == 1 && $volunteerInfo->individualStatus == false){
                            try {
                                $exam = Exam::where('examID', '=', $basketOriginal->examID)->firstOrFail();
                                echo 'x';
                                $basket = new Basket();
                                $basket->basketID = str_random(7);
                                $basket->questionID = $basketOriginal->questionID;
                                $basket->basketStatus = 'Active';
                                $basket->basketScore = $basketOriginal->basketScore;
                                $basket->flag = 1;
                                echo '6';
                                $basket->save();
                                //echo 'saved';
                                $exam->basket()->save($basket);
                                $volunteer->Rbasket()->save($basket);
                                $questioner->Qbasket()->save($basket);
                                $volunteerInfo->individualStatus = false;
                                $volunteerInfo->finalScore -= $exam->questionScore;
                                $basket->basketScore += $exam->questionScore;
                                $basket->save();
                                $volunteerInfo->save();
                                echo 'saved';
                                echo $cnt++;
                                $resultBaskets->push(['basket'=>$basket]);
                                //Do stuff when exam exists.
                            } catch (\Exception $s) {
                                echo 'exam';
                                //echo $s;
                                continue;
                                //Do continue if it doesn't exist.
                            }
                            //echo '5.5';
                            //return 1;
                        }
                        //Do stuff when user exists.
                    } catch (\Exception $e) {
                        //echo $e;
                        echo 'eee';
                        continue;
                        //Do continue if it doesn't exist.
                    }
                }
                //Do stuff when user exists.
            } catch (\Exception $g) {
                echo 'ggg';
                //echo $g;
                continue;
                //Do continue if it doesn't exist.
            }

            $basketOriginal->basketStatus = 'deActive';
            $basketOriginal->save();
        }
        $requestToQuestionPart = collect(['data' => $resultBaskets])->toJson();
        echo $requestToQuestionPart;
        $client = new client();
        try {
            $response = $client->post('http://software:81/l', ['json' => $requestToQuestionPart]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            echo 'Caught response: ' . $e->getResponse()->getStatusCode();
        }
        //$r = $response->send();
        //dd($response);
        return $requestToQuestionPart;
        //...
        //Ready to send to quesion part
    }

    public function volunteerExitRequest(Request $request){
        $user = $request->user();
        $classExam = $user->classes();
        $exitPersonRequest = collect(['data' => [['person' => ['personalID' => $user->personalID, 'classID' => $classExam->classID]],
                                            "ticket" => "volunteerRespondUserTicket"]])->toJson();
        $client = new client();
        try {
            $response = $client->post('http://software:81/l' /*enter exit system*/, ['data' => [['person' => ['personalID' => $user->personalID, 'classID' => $classExam->classID]],
                "ticket" => "volunteerRespondUserTicket"]]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            echo 'Caught response: ' . $e->getResponse()->getStatusCode();
        }
        //ready for sending to enter and exit
    }

    public function volunteerExitResult(Request $request){
        $enteredPersonRequest = collect(['data' => [['person' => ['personalID' => '1234567', 'classID' => '1234567']],
                                            "ticket" => "volunteerRespondUserTicket"]])->toJson();
        try {
            if(Classindividual::where('personalID', '=', $request['data']['person']['personalID'])->exists()){
                $user = Classindividual::where('personalID', '=', $request['data']['person']['personalID'])->firstOrFail();
                $user->isPresent = 0;
                $user->save();
            }
            //Do stuff when user exists.
        } catch (Exception $e) {
            return 1;
            //Do stuff if it doesn't exist.
        }
    }

    public function userForceExit(Request $request, Classindividual $person){
        $classExam = $person->classes();
        $person->isPresent = 0;
        $person->save();
        $userForceExitRequest = collect(['data' => [['person' => ['personalID' => $person->personalID, 'classID' => $classExam->classID]],
                                            "ticket" => "volunteerRespondUserTicket"]])->toJson();

        $client = new client();
        try {
            $response = $client->post('http://software:81/l' /*force exit*/, ['data' => [['person' => ['personalID' => $person->personalID, 'classID' => $classExam->classID]],
                "ticket" => "volunteerRespondUserTicket"]]);

        }catch(\Exception $e){

        }
        //ready for sending to enter and exit system
    }

    // <!-- /Amir Hossein -->

    public function volunteer(Request $request)
    {
        $jj=json_decode($request);

        $rr = $request->json();
        $basket = new Basket();
        $basket-> basketID = $rr-> all()['data']['basket']['basketID'];
        $basket-> examID = $rr-> all()['data']['basket']['examID'];
        $basket-> questionerID= $rr-> all()['data']['basket']['questionerID'];
        $basket-> responderedID= $rr-> all()['data']['basket']['responderedID'];
        $basket-> basketScore= $rr-> all()['data']['basket']['basketScore'];
        //$basket-> participantID = $rr-> all()['data']['person']['participantID'];
        $basket-> save();
        dd( $jj);

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
        $volunteerSendBasketsWithUsers = collect(['data' => ['basketsArray' => [['basket' => 'bjson'],['basket' => 'bjson']]] , 'ticket' => 'volunteerSendBasketsWithUsersTicket']);


        /*
         * post to volunteer server
         * send basket that unSolved to volunteer server
         */
        $volunteerSendUnSolvedBasket = collect(['data' => ['unResolvedBasket' =>'bJson'],'ticket' => 'volunteerSendUnSolvedBasketTicket']);

        return response()->json($volunteerRespondUser);
        return $volunteerSendUnSolvedBasket ->toJson();
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

    public function Judge(){

        /*
         * post to judge server
         * send basket to judge
         */
        $sendToJudge = collect(['data' =>['basket' =>'bJson'],'thicket' => 'sendToObjectedTicket']);

        /*
         * api for get result of judging
         */
        $getAnswerFromJudge = collect(['data' => ['basket' =>'bJson','Judge'=>'accepted','desc'=>'Description']]);

        return $getAnswerFromJudge ->toJson();
    }

    public function EnterAndExit(Request $request){
    //   $rr= $request->json();
      //  dd($rr->all()['data']['basketsArray'][0]['basket']);
       // $request = Request::instance()->getContent();
        //dd($request);
//        return $request;
        if ($request->isjson())
        {
           return 1;
        }
       $jj=json_decode($request);

        $rr= $request->json();
        $user = new Studentinfo();
        $user -> examID = $rr-> all()['data']['person']['examID'];
        $user -> participantID = $rr-> all()['data']['person']['participantID'];
        $user -> save();

        dd( $jj);

        return $request->json()->all()[data];
        return $jj->data;
        return response() ->json($request);

        return response()->json($request );
        $h = new User();

        /*
         * api for get student to Start Exam Game
         */
        $getEnterStudent = collect(['data' => ['person' =>'SJson'],'ticket' =>'EnterUserTicket']);


        /*
         * api for get Student to Exit From Game
         */

        $getExitStudent = collect (['data' => ['person' =>'SJson'] , 'ticket' => 'ExitUserTicket']);

        /*
         *send users for force exit
         */
        $sendForceExitStudentToEnterAndExitPart = collect(['data' => ['persons' =>['person' => 'SJson']] , 'ticket' => 'ForceExitTicket']);

        return $sendForceExitStudentToEnterAndExitPart -> toJson();
    }

    public function questionPlatform(){

    }
}