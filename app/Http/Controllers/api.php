<?php
/**
 * Created by PhpStorm.
 * User: hkafi
 * Date: 12/25/2016
 * Time: 12:29 AM
 */

//todo mohsen

namespace App\Http\Controllers;

use App\Classexam;
use App\Classindividual;
use App\Exam;
use App\Http\Controllers\amircontroller;
use App\Studentinfo;
use App\User;
use Illuminate\Support\Facades\Redis;
use App\Basket;
use Exception;
use Symfony\Component\HttpFoundation\ParameterBag;
use Illuminate\Http\Request;
use App\Http\Requests;
use GuzzleHttp\client;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7;

//use App\Http\Requests\Request;

//use Illuminate\Support\Facades\Request;

class api extends Controller
{
    //todo prestart
    // <!-- Amir Hossein -->
    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */

    // Test: OK
    public function forceuserexit($id)
    {
        try {
            $user = Studentinfo::where('participantID', '=', $id)->firstOrFail();
            if ($user->roundNumber > 3 && $user->finalScore < 5) {
                //echo 'Exit';
                $student = Classindividual::where('personalID', '=', $id)->firstOrFail();
                //echo 'here';
                $this->userForceExit($student);
                return;
            } else {
                echo 'No need to Exit';
                return;
            }
        } catch (\Exception $e) {

        }
    }

    // Test: OK
    public function attributes($id)
    {
        try {
            //dd($id);
            $res = array();
            $student = Studentinfo::where('participantID', '=', $id)->firstOrFail();
            $max = Studentinfo::all()->max('finalScore');
            $avg = Studentinfo::all()->sum('finalScore') / Studentinfo::all()->count();
            $min = Studentinfo::all()->min('finalScore');
            $studentnumbers = Studentinfo::all()->count();
            $maxroundNum = Studentinfo::all()->max('roundNumber');
            array_push($res, $student, $max, $min, $avg, $studentnumbers, $maxroundNum);
            return $res;
        } catch (Exception $e) {
            return 'attributes';
        }
    }

    // Test: OK
    public function getEnteredPerson(Request $request)
    {
        $enteredPersonRequest = collect(['data' => ['person' => ['personalID' => '1274568', 'role' => 'instructor', 'classID' => '1111111'],
            "ticket" => "volunteerRespondUserTicket"]])->toJson();

        $redis = Redis::connection();
        $last = null;
        
        $Q = Studentinfo::all()->where('QorR', 1)->count();
        $R = Studentinfo::all()->where('QorR', 0)->count();
        try {
            if ($Q == $R) {
                $qor = rand(0, 1);
            }
            else if ($Q > $R) {
                $qor = 0;
            }
            else{
                $qor = 1;
            }/*
            if (Studentinfo::all()->count() == 0) {
                $qor = 0;
            } else {
                $last = Studentinfo::all()->last();
                $redis->publish('log', $last);
                $qor = $last->QorR;
               // $qor = 1;
            }
            $redis->publish('log', 'no problem');*/
        } catch (Exception $e) {
           // $redis->publish('log', 'no');
        }
        $er = json_decode($request->data);
        $r = json_decode($request);
        //$redis->publish('log', $r);
        $request = $er;
        //$qor = rand(0, 1);
        try {
            if (Classindividual::where('personalID', $request->data->person->personalID)->exists()) {
                $person = Classindividual::where('personalID', $request->data->person->personalID)->firstOrFail();

                if ($person->accessibility == 0) {
                    return redirect()->route('client', $person->personalID);
                } else {
                    return redirect()->route('client2', $person->personalID);
                }
            }

            $class = Classexam::where('classID', '=', $request->data->person->classID)->firstOrFail();
            $exam = $class->exam()->get();
            //return $exam;
            $person = new Classindividual();
            $person->personalID = $request->data->person->personalID;
            $person->classID = $request->data->person->classID;
            //$person->classID = '1111111';
            $person->isPresent = 1;
            $person->isActive = 1;

            //todo check Instructor string with enter and exit
            if ($request->data->person->role == 'instructor') {
                $person->accessibility = 1;
            } else {
                $person->accessibility = 0;
            }
            $person->save();
            session([$person->personalID => $request->data->token]);
            \Session::save();
            $se = session(9327303);
            //$redis->publish('log', var_dump($se));
            $student = new Studentinfo();
            $student->roundNumber = 0;
            $student->individualStatus = 0;
            $student->platform = $request->data->person->platform;
            $student->finalScore = $exam[0]->average;
           /* if ($last == null) {
                $student->QorR = 1;
            } else*/ if ($qor == 0) {
                $student->QorR = 0;
            } else {
                $student->QorR = 1;
            }
            $student->examID = $exam[0]->examID;
            $student->save();
            $person->person()->save($student);
            if ($person->accessibility == 1) {
                //return 'Hello teacher';
                $student->QorR = 1;
                $student->individualStatus = 1;
                $student->save();
                return redirect()->route('client2', $student->participantID);
                //return view('teacher.teacherMain');
            }
            //$parameter = ['stdID' => $student->participantID];
            //return redirect()->route('client', ['stdID' => $parameter]);
            return redirect()->route('client', $student->participantID);//Todo set mohsen
            //todo mohsen
        } catch (Exception $e) {
            echo $e;
        }
    }

    // Test: OK
    public function getEnteredPerson2(Request $request)
    {
        $enteredPersonRequest = collect(['data' => ['person' => ['personalID' => '1274568', 'role' => 'instructor', 'classID' => '1111111'],
            "ticket" => "volunteerRespondUserTicket"]])->toJson();
        $redis = Redis::connection();
        // $redis->publish('log', "inja");
        $Q = Studentinfo::all()->where('QorR', 1)->count();
        $R = Studentinfo::all()->where('QorR', 0)->count();
        try {
            if ($Q == $R) {
                $qor = rand(0, 1);
            }
            else if ($Q > $R) {
                $qor = 0;
            }
            else{
                $qor = 1;
            }/*
            if (Studentinfo::all()->count() == 0) {
                $qor = 0;
            } else {
                $last = Studentinfo::all()->last();
                $redis->publish('log', $last);
                $qor = $last->QorR;
               // $qor = 1;
            }
            $redis->publish('log', 'no problem');*/
        } catch (Exception $e) {
           // $redis->publish('log', 'no');
        }

        //return !(true);
        //return $enteredPersonRequest;
        //dd($enteredPersonRequest);
        //return $enteredPersonRequest;
        //$client = new Client();
        //$r = $client->request('POST', 'http://blog:81/post', ['json' => [$enteredPersonRequest]]);
       // $redis->publish('log', 'jjjj');
        try {
            /*$request = $request->json()->all();
            return $request['data']['person']['personalID'];*/
            //$request =  $request->json()->all();
            //$request = json_decode($request[0], true);
            //$redis->publish('log',$request);
            /*foreach ($er as $request) {
                echo $er;
            }*/
            $request = $request->json()->all();
            //$redis->publish('log', $request);
            //return 'yes';
            //return 1;
          }
        catch(Exception $e)
        {
           // $redis->publish('log', $e);
        }
        //dd($request);
        //$data = $request['data']['person']['personalID'];
       
        //$redis->publish('log',$request['data']);
        
        try {
            if (Classindividual::where('personalID', $request['data']['person']['personalID'])->exists()) {
                $person = Classindividual::where('personalID', $request['data']['person']['personalID'])->firstOrFail();
                if ($person->accessibility == 0) {
                    //return redirect()->route('client', $person->personalID);
                    return true;
                } else {
                    //return redirect()->route('client2', $person->personalID);
                    return true;
                }
            }
            $class = Classexam::where('classID', '=', $request['data']['person']['classID'])->firstOrFail();
            $exam = $class->exam()->get();
            //return $exam;
            $person = new Classindividual();
            $person->personalID = $request['data']['person']['personalID'];
            $person->classID = $request['data']['person']['classID'];
            //$person->classID = '1111111';
            $person->isPresent = 1;
            $person->isActive = 1;

            //todo check Instructor string with enter and exit
            if ($request['data']['person']['role'] == 'instructor') {
                $person->accessibility = 1;
            } else {
                $person->accessibility = 0;
            }
            //return $request['data'];
            $person->save();
            //session([$person->personalID => $request->data->token]);
           // $se = session($person->personalID);

            $student = new Studentinfo();
            $student->roundNumber = 0;
            $student->individualStatus = 0;
            $student->platform = $request['data']['person']['platform'];
            $student->finalScore = $exam[0]->average;
            /*if ($last == null) {
                $student->QorR = 1;
            } else*/ if ($qor == 0) {
                $student->QorR = 0;
            } else {
                $student->QorR = 1;
            }
            $student->examID = $exam[0]->examID;
            $student->save();
            //$redis->publish('log','enter');
            //$redis->publish('log',$student);
            $person->person()->save($student);
            if ($person->accessibility == 1) {
                //return 'Hello teacher';
                $student->QorR = 1;
                $student->individualStatus = 1;
                $student->save();
                //return redirect()->route('client2', $student->participantID);
                return true;
                //return view('teacher.teacherMain');
            }
            //$parameter = ['stdID' => $student->participantID];
            //return redirect()->route('client', ['stdID' => $parameter]);
            //return redirect()->route('client', $student->participantID);//Todo set mohsen
            return true;
            //todo mohsen
        } catch (Exception $e) {
            $redis->publish('log',$e);
            echo $e;
        }
    }


    // Test: OK
    public function questionPartResult(Request $request)
    {
        $redis= Redis::connection();
        /*$questionPartRequest = collect(['data' => ['basket' => 'sds'], "ticket" => "volunteerRespondUserTicket"])->toJson();*/
        $request = $request->json()->all();
        try {
            $basketOriginal = Basket::where('basketID', '=', $request['data']['basket']['basketID'])->firstOrFail();
            $responder = Studentinfo::where('participantID', '=', $basketOriginal->responderedID)->firstOrFail();
            $questioner = Studentinfo::where('participantID', '=', $basketOriginal->questionerID)->firstOrFail();
            $responderPerson = $responder->individuals();
            $questionerPerson = $questioner->individuals();

            if ($basketOriginal->basketStatus == 'deActive' || $basketOriginal->basketStatus == 'volunteer'
                || $responderPerson->isPresent == 0 || $questionerPerson->isPresent == 0
            ) {
                return 'deActive basket recieved or responder not exist';
            } else if ($request['data']['answer']['result'] == 0/* ... if responder gave wrong answer to the question */) {
                if($responderPerson->accessibility == 1){
                    //do nothing
                }
                else{
                    $responder->individualStatus = 0;
                    $responder->save();
                }

                if($questionerPerson->accessibility == 1){
                    //do nothing
                }
                else{
                    $questioner->individualStatus = 0;
                    $questioner->save();
                }
                $this->forceuserexit($responder->participantID);
                $this->forceuserexit($questioner->participantID);
                $basketOriginal->basketStatus = 'Volunteer';
                $basketOriginal->questionID = $request['data']['question']['questions'][0]['id'];
                $basketOriginal->flag = 1;
                $basketOriginal->save();
                $client = new client();
                try {
                    $requesttoVolunteer=collect(['data'=>['basket'=>$basketOriginal],'ticket'=>'volunteerSendBasketTicket']);
             $redis->publish('log','volunteerresponse:');
         $redis->publish('log',$requesttoVolunteer->toJson());
                    $response = $client->request('POST', 'http://volunteer.intellexa.me/api/', ['json' => $requesttoVolunteer]);//todo volunteery system
                   
                    $redis->publish('log',$response->getBody());

                    //todo mohsen redirect
                } catch (\GuzzleHttp\Exception\ClientException $e) {
                    $redis->publish('log',$e);
                    echo 'Caught response: ' . $e->getResponse()->getStatusCode();
                }
            } else {
                $responder->finalScore += $basketOriginal->basketScore;
                $responder->save();
                if($responderPerson->accessibility == 1){
                    //do nothing
                }
                else{
                    $responder->individualStatus = 0;
                    $responder->save();
                }

                if($questionerPerson->accessibility == 1){
                    //do nothing
                }
                else{
                    $questioner->individualStatus = 0;
                    $questioner->save();
                }
                $basketOriginal->basketStatus = 'deActive';
                $basketOriginal->questionID = $request['data']['question']['questions'][0]['id'];
                $basketOriginal->save();
                $this->forceuserexit($questioner->participantID);
                $this->forceuserexit($responder->participantID);
            }
        } catch (Exception $e) {
            echo 'NOT A VALID DATA RECIEVED';
            return $e;
        }
    }

    //todo test with mahdi bakhshi
    public function volunteerResult(Request $request)
    {
        //$b = Basket::where('basketStatus', '=', 'volunteer')->firstOrFail();
        /*$questionPartVolunteerRequest = collect(['data' => ['basket' => '', "respondentlist" => ['RS8DaLx', 'DqA02oI', 'pZu9C0T']]
            ,"ticket" => "volunteerRespondUserTicket"])->toJson();*/
        //todo redirect mohsen
        $request = $request->json()->all();
        dd($request);
        try {
            $correctResponders = array();
            $basketOriginal = Basket::where('basketID', '=', $request['data']['basket']['basketID'])->firstOrFail();
            $respondersInfo = $request['data']['respondentlist'];

            if ($basketOriginal->basketStatus == 'deActive') {
                return 'deActive Basket Recieved.';
            } else {
                $correctAnswerNumber = 0;
                foreach ($respondersInfo as $responderInfo) {
                    $responder = Studentinfo::where('participantID', '=', $responderInfo)->firstOrFail();
                    if ($responderInfo['answer']['result'] == 1 /* True answer */) {
                        array_push($correctResponders, $responder);
                        $correctAnswerNumber++;
                    } else {
                        continue;
                    }
                }
                $basketOriginal->basketStatus = 'deActive';//todo test
                if ($correctAnswerNumber >= 0) {
                    $bonus = $basketOriginal->basketScore / $correctAnswerNumber;
                    foreach ($correctResponders as $resp) {
                        $responderPerson = Classindividual::where('personalID',$resp->participantID)->firstOrFail();
                        $resp->finalScore += $bonus;
                        if($responderPerson->accessibility == 1){
                            //do nothing
                        }
                        else{
                            $resp->individualStatus = 0;
                            $resp->save();
                        }
                        $this->forceuserexit($resp->participantID);
                    }
                } else {
                    foreach ($respondersInfo as $responderInfo) {
                        $responder = Studentinfo::where('participantID', '=', $responderInfo)->firstOrFail();
                        $responderPerson = Classindividual::where('personalID',$responder->participantID)->firstOrFail();
                        if($responderPerson->accessibility == 1){
                            //do nothing
                        }
                        else{
                            $responder->individualStatus = 0;
                            $responder->save();
                        }
                        $this->forceuserexit($responder->participantID);
                    }
                    try {
                        $questioner = Studentinfo::where('participantID', '=', $basketOriginal->questionerID)->firstOrFail();
                        $questioner->finalScore += Exam::all()->take(1)[0]->questionScore;
                        $questioner->save();
                        $this->forceuserexit($questioner->participantID)->firstOrFail();
                    } catch (\Exception $e) {
                        echo 'volunteerResult';
                    }
                }
            }
            //Do stuff when user exists.
        } catch (Exception $e) {
            return $e;
            //Do stuff if it doesn't exist.
        }
    }

    // Test: OK
    public function getObjectedToScoreBasket(Request $request)
    {

          $redis = Redis::connection();
          $redis->publish('log','getObjectedToScoreBasket:');
          $redis->publish('log',$request);
          //$redis->publish('log',$request->getContent());
         // return 1;
                    //$client = new client();
                    //$response = $client->request('POST', 'http://judge.intellexa.me/rfj/', ['json' => $request]); 
                    //dd($response); 
                           // $redis->publish('log',$request);
        //todo redirect or not me and mohsen with mahdi
        $objectedrequest=$request->getContent();
        $request = $request->json()->all();
        //return $request['data'];
        try {
            $basketOriginal = Basket::where('basketID', '=', $request['data']['basket']['basketID'])->firstOrFail();
            $objector = Studentinfo::where('participantID', '=', $basketOriginal->responderedID)->firstOrFail();
            $objectorPerson = $objector->individuals();
            $exam = Exam::where('examID', '=', $basketOriginal->examID)->firstOrFail();
            if ($basketOriginal->basketStatus == 'deActive' || $objectorPerson->isPresent == 0) {
                return json_encode('deActive basket or not a valid person recieved');
            } else {
                $objector->finalScore -= $exam->questionScore;
                $basketOriginal->basketScore += $exam->questionScore;
                $objector->save();
                $basketOriginal->questionID = $request['data']['question']['questions'][0]['id'];
                $basketOriginal->save();
                //echo 'did it right';
                $client = new client();
                $response = $client->request('POST', 'http://judge.intellexa.me/rfj/', ['json' => $objectedrequest]);
                $redis = Redis::connection();
                $redis->publish('log','judge:');
                $redis->publish('log',$response->getBody());
            }

        } catch (Exception $e) {
            $redis->publish('log',$e);
            return json_encode('NOT A VALID DATA RECIEVED');
            //Do stuff if it doesn't exist.
        }
        //...
        //Ready to send to objection system
    }

    //Test: OK
    public function getObjectedToScoreBasketResult(Request $request)
    {
        $request = $request->json()->all();
        //return $request['data'];
        try {
            $basketOriginal = Basket::where('basketID', '=', $request['data']['basket']['basketID'])->firstOrFail();
            $objector = Studentinfo::where('participantID', '=', $basketOriginal->responderedID)->firstOrFail();
            $objectorPerson = $objector->individuals();
            //return $basketOriginal->questionerID;
            $questioner = Studentinfo::where('participantID', '=', $basketOriginal->questionerID)->firstOrFail();
            $questionerPerson = Classindividual::where('personalID', $questioner->participantID)->firstOrFail();
            //return 'here';

            //echo '$objectorPerson';
            if (($basketOriginal->basketStatus == 'deActive' || $objectorPerson->isPresent == 0)) {
                return json_encode('deActive basket or not a valid user recieved');
            } else if (($basketOriginal->basketStatus == 'Active' || $objectorPerson->isPresent == 1) && /*todo true or accepted*/
                $request['data']['judge'] != 'accepted'
            ) {
                //return 'there';
                $basketOriginal->basketStatus = 'Volunteer';
                $basketOriginal->save();
                $volunteerRequest = collect(['data' => ['basket' => $basketOriginal, 'ticket' => 'volunteerRespondUserTicket']])->toJson();
                if ($objectorPerson->accessibility == 1) {
                    //todo something went wrong
                    
                } else {
                    $objector->individualStatus = 0;
                    $objector->save();
                }

                if ($questionerPerson->accessibility == 1) {
                    //do nothing    
                }
                else{
                    $questioner->individualStatus = 0;
                    $questioner->save();
                }
                $this->forceuserexit($objector->participantID);
                $this->forceuserexit($questioner->participantID);
                $client = new client();
                try {
                    $response = $client->request('POST', 'http://volunteer.intellexa.me/api/', ['json' => $basketOriginal]);//todo variable and link
                } catch (\GuzzleHttp\Exception\ClientException $e) {
                    //echo 'Caught response: ' . $e->getResponse()->getStatusCode();
                }
            } else {
                //return 'here';
                $objector->finalScore += $basketOriginal->basketScore;
                $objector->save();
                $basketOriginal->basketStatus = 'deActive';
                $basketOriginal->save();
                if ($objectorPerson->accessibility == 1) {
                    //todo something went wrong
                    
                } else {
                    $objector->individualStatus = 0;
                    $objector->save();
                }

                if ($questionerPerson->accessibility == 1) {
                    //do nothing    
                }
                else{
                    $questioner->individualStatus = 0;
                    $questioner->save();
                }
                $this->forceuserexit($objector->participantID);
                $this->forceuserexit($questioner->participantID);
            }
            //Ready to send the volunteery basketID to volunteer system
            //Do stuff when user exists.
        } catch (Exception $e) {
            return json_encode('NOT A VALID DATA RECIEVED');
        }
        //...
    }

    //Test: OK
    public function getVolunteersBasket(Request $request)
    {
             $redis = Redis::connection();
             $redis->publish('log','getVolunteerBasket:');
        $redis->publish('log',$request);
        $b = Basket::where('basketID', 'istIzZX')->firstOrFail();
        $volunteerRequest = collect(['data' => ['basketsArray' => [
            ['basket' => $b, "respondentlist" => ['1234567', '1OLuRvU', '38V4LNL']]
            , ['basket' => $b, "respondentlist" => ['38V4LNL']]
            , ['basket' => $b, "respondentlist" => ['3jQCyvA']]]]
            , "ticket" => "volunteerRespondUserTicket"])->toJson();
        //return $volunteerRequest;
        $request = $request->json()->all();
        $volunteerBaskets = $request['data']['basketsArray'];
        //return $volunteerBaskets;
        $resultBaskets = collect();
       
        foreach ($volunteerBaskets as $vBasket) {
            try {
                //return $vBasket['basket']['basketID'];
                $basketOriginal = Basket::where('basketID', '=', $vBasket['basket']['basketID'])->firstOrFail();
                if ($basketOriginal->basketStatus == 'deActive') {
                    return json_encode('deActive basket recieved');
                }
                $volunteers = $vBasket['respondentlist'];
                //return $volunteers;
                $cnt = 0;
                foreach ($volunteers as $volunteer1) {
                    try {
                        $volunteerInfo = Studentinfo::where('participantID', '=', $volunteer1)->firstOrFail();
                        $volunteer = $volunteerInfo->individuals();
                        $questionerInfo = Studentinfo::where('participantID', '=', $basketOriginal->questionerID)->firstOrFail();
                        $questioner = $questionerInfo->individuals();
                        if ($volunteer->isPresent == 1 && $volunteerInfo->individualStatus == 0 && $basketOriginal->basketStatus == 'Volunteer') {
                            try {
                                echo "oomad";
                                $exam = Exam::where('examID', '=', $basketOriginal->examID)->firstOrFail();
                                $volunteerInfo->individualStatus = 1;
                                $volunteerInfo->finalScore -= $exam->questionScore;
                                $basketOriginal->basketScore += $exam->questionScore;
                                $basketOriginal->save();
                                $volunteerInfo->save();
                                //todo check whether the client must be redirected from volunteer system
                                //todo on their own or we must redirect them   mohsen
                            } catch (\Exception $s) {
                                echo 'getVolunteerBasket';
                                continue;
                                //Do continue if it doesn't exist.
                            }
                        } else {
                            return json_encode('invalid person or unfree student or invalid basket recieved');
                        }
                    } catch (\Exception $e) {
                        return json_encode('invalid data recieved');
                        //Do continue if it doesn't exist.
                    }
                }
                //Do stuff when user exists.
            } catch (\Exception $g) {
                return json_encode('NOT A VALID DATA RECIEVED');
            }
            $basketOriginal->basketStatus = 'volunteer';
            $basketOriginal->save();
        }
        //$requestToQuestionPart = collect(['data' => $request])->toJson();
        try {
            $client = new client();
            $response = $client->request('POST', 'http://77.244.214.149:3000/getVolunteerBasket', ['json' => $request->toJson()]);//todo link mohsen mahdi
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            echo 'Caught response: ' . $e->getResponse()->getStatusCode();
            echo 'unsuccessful post response recieved';
        }
        //Ready to send to quesion part
    }

    //Test: ??
    public function volunteerExitRequest(Request $request)
    {
        //todo we must check on our own how to pass student id from the page to controller
        //todo must handle redirecting user important
        $student = Studentinfo::where('participantID', $request->id)->firstOrFail();
        //$classExam = $student->classes();
        $exitPersonRequest = collect(['data' => ['person' => [$student], 'classID' => '1111111'],
            "ticket" => "volunteerRespondUserTicket"])->toJson();
        $client = new client();
        try {
            //todo post must be checked
            $response = $client->request('post', 'https://sign.intellexa.me/volunteer_logout' /*enter exit system*/, ['json' => $exitPersonRequest]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            echo 'Caught response: ' . $e->getResponse()->getStatusCode();
        }
    }
    public function gotovolunteer (Request $request)
    { $client = new client();
        try {
            $data= collect(['data'=>['userid'=>$request->userid],'ticket'=>'volunteerSendUserTicket']);
     $response = $client->request('post', 'http://volunteer.intellexa.me/api/', ['json' => $data]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            echo 'Caught response: ' . $e->getResponse()->getStatusCode();
        }
            return redirect('http://volunteer.intellexa.me/client/'.$request->userid);

    }
    /*
    public function volunteerExitResult(Request $request)
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

    //Test: OK
    public function userForceExit(Classindividual $person)
    {
        //todo needtotest
        $person->isPresent = 0;
        $person->save();
        $student = Studentinfo::where('participantID', '=', $person->personalID)->firstOrFail();
        return 'in the last function';
        //todo need socket
        $userForceExitRequest = collect(['data' => ['person' => $student, 'classID' => '1111111'],
            "ticket" => "volunteerRespondUserTicket"])->toJson();
        $client = new client();
        try {
            $response = $client->request('post', 'http://sign.intellexa.me/logout/' /*force exit*/, ['json' => $student]);
            // Todo return redirect('http://sign.intellexa.me/force_logout/');
        } catch (\Exception $e) {
        }
        //ready for sending to enter and exit system
    }

    // <!-- /Amir Hossein -->


    /*
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
        $volunteerSendUser = collect(['data' => ['userlist' => [1, 2, 3]], 'ticket' => 'volunteerSendUserTicket']);

        $volunteerRespondUser = collect(['data' => ['basketsArray' => [['basket' => 'bjson', 'respondentlist' => [1, 2, 3]], ['basket' => 'bjson', 'respondentlist' => [1, 2, 3]]]], 'ticket' => 'volunteerrespondUserTicket']);


        $volunteerSendBasketsWithUsers = collect(['data' => ['basketsArray' => [['basket' => 'bjson'], ['basket' => 'bjson']]], 'ticket' => 'volunteerSendBasketsWithUsersTicket']);

        $volunteerSendUnSolvedBasket = collect(['data' => ['unResolvedBasket' => 'bJson'], 'ticket' => 'volunteerSendUnSolvedBasketTicket']);

        return response()->json($volunteerRespondUser);
        return $volunteerSendUnSolvedBasket->toJson();
        //  $baskets = json_decode($request->baskets);
        $f = Studentinfo::find(1);
        $f->reduceGrade(2);
        foreach (user as $baskets->user) {

        }
        foreach (basket as $baskets) {
            sendToAnswerQuestionPart(basket);
        }
    }

    public function Judge()
    {
        $sendToJudge = collect(['data' => ['basket' => 'bJson'], 'thicket' => 'sendToObjectedTicket']);
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

        $getEnterStudent = collect(['data' => ['person' => 'SJson'], 'ticket' => 'EnterUserTicket']);

        $getExitStudent = collect(['data' => ['person' => 'SJson'], 'ticket' => 'ExitUserTicket']);

        $sendForceExitStudentToEnterAndExitPart = collect(['data' => ['persons' => ['person' => 'SJson']], 'ticket' => 'ForceExitTicket']);

        return $sendForceExitStudentToEnterAndExitPart->toJson();
    }

    */

    /*
        public function questionPlatform()
        {

        }
    */
}
