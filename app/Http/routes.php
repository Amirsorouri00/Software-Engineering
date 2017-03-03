<?php

/*
|--------------------------------------------------------------------------
| Routes File
|--------------------------------------------------------------------------
|
| Here is where you will register all of the routes in an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| This route group applies the "web" middleware group to every route
| it contains. The "web" middleware group is defined in your HTTP
| kernel and includes session state, CSRF protection, and more.
|
*/

use Carbon\Carbon;
use GuzzleHttp\Client;
use Illuminate\Http\Request;
use App\User;
use App\Studentinfo;



Route::group(['middleware' => ['web']], function () {

    Route::get('/', function () {
        return view('welcome');
    })->middleware('guest');
    Route::get('test', 'amircontroller@matchwithperiod');

    Route::get('api/exams', function(){
        return App\Exam::all();
    });

    Route::post('api/exams', function(){
        App\Exam::create(Request::all());
    });

    Route::get('guestexam', function(){
        return view('guestexam');
    });


    Route::get('/main/{userid}', function ($userid) {
        //return $request;
      //  session(['userid2' => $userid]);
       // return session()->all();
        $api = new \App\Http\Controllers\api();
                $student = Studentinfo::where('participantID', $userid)->firstOrFail();
        $exitPersonRequest = collect(['data' => ['person' => $student, 'classID' => '1'],
            "ticket" => "volunteerRespondUserTicket"]);
        //dd(json_encode($exitPersonRequest['data'], true));
        return view('main', ['exit' => json_encode($exitPersonRequest, true)])->with('info', $api->attributes($userid));
        return view('main')->with('info', $api->attributes($userid));
    });

    Route::post('teacherUpdateStatus', function(Request $request){
        $teacher = Studentinfo::where('name', 'pattern');
    });

    Route::post('api/teacherstatus', function(Request $request){
      try{
        $teacher = Studentinfo::where('participantID', $request->json)->firstOrFail();
        $teacher->individualStatus = 0;
        $teacher->save();

        return 'yeeeeeeeeeees';
      }catch(\Exception $e){
        return 'noooooooooooooooo';
      }

    });

    /* Android Exit */
    //  
    Route::post('/androidVolunteerExit', function(Request $request){

    });

    /*
    * Api Controller Routes Amirsorouri00
    */
    Route::post('/entertogame2', 'api@getEnteredPerson2');

    // This Route Handles Any New Entered Player    Test: OK
    Route::post('/entertogame', 'api@getEnteredPerson');
    // This Route Gets Basket From QuestionPart And Handles Whether It Must Be Redirected Or Must Be Posted To
    // Volunteer Subsystem    Test: OK
    Route::post('/questionPartResult', 'api@questionPartResult');
    // QuestionPart Posted Us Volunteer Baskests Results Using This Route Api     Test:OK
    Route::post('volunteerResult', 'api@volunteerResult');
    // QuestionPart Sends Baskets To This Route And We Send That To Objection Subsystem.    Test: OK
    Route::post('/getObjectedBasket', 'api@getObjectedToScoreBasket');
    // Objection Sends Baskets To This Route And We Decide Whether It Must Be Deactivated Or Sent To
    // Volunteer Subsystem    Test: OK
    Route::post('/getObjectionResult', 'api@getObjectedToScoreBasketResult');
    // VolunteerPart Sends Baskets With Their Respondent, We Post That Request To QuestionPart After
    // Doing Some Processes In Database    Test: OK
    Route::post('/getVolunteers', 'api@getVolunteersBasket');
    // We Call This Route for Sending Players To Exit Part And They Should Get User Out Of The Game
    // If They Must Be Out In Order To Their Information Into Our Database
    //Route::post('volunteerExit', 'api@volunteerExitRequest');
    Route::post('volunteerExit/{studeninfoid}', function ($studeninfoid) {
        //todo we must check on our own how to pass student id from the page to controller
        //todo must handle redirecting user important
        //return $studeninfoid;
        $student = \App\Studentinfo::where('participantID', $studeninfoid)->firstOrFail();
        //$str=str_replace("\r\n","",$student);
        //return $str;
        $exitPersonRequest = collect(['data' => ['person' => $student, 'classID' => '1111111'],
            "ticket" => "volunteerRespondUserTicket"])->toJson();
        //return $exitPersonRequest;
        //return 'this is right time for exiting from the game';
        try {
            $client = new client();
            $response = $client->request('post', 'http://sign.intellexa.me/volunteer_logout' /*enter exit system*/, ['json' => $exitPersonRequest]);
        } catch (\GuzzleHttp\Exception\ClientException $e) {
            echo 'Caught response: ' . $e->getResponse()->getStatusCode();
        }
    });
    Route::post('/gotovolunteer','api@gotovolunteer');
    Route::post('eybaba', function(Request $request){
        dd( json_decode($request->exit)->data->person->participantID);
    });

    /*
    * Teacher Routes Controller Amirsorouri00
    */
    // Route For Teacher Entering To Game
    Route::post('teacherEntertoGame/{studentinfo}', 'Teachercontroller@teacherEntertoGame');
    Route::get('teacherlogin', 'Teachercontroller@login');
    Route::get('/client/{stdID}', ['as' => 'client', function (Request $request, $stdID) {
        //dd($request->stdID);
        $api = new \App\Http\Controllers\api();
        $student = Studentinfo::where('participantID', $stdID)->firstOrFail();
        $exitPersonRequest = collect(['data' => ['person' => $student, 'classID' => '1'],
            "ticket" => "volunteerRespondUserTicket"])->toJson();
        return view('main', ['exit' => $exitPersonRequest])->with('info', $api->attributes($stdID));
        //return $stdID;
        return view('client', ['stdID' => $request->stdID]);
    }]);
    // Route For Teacher In Order To Enter To Next Round
    // Route::get('enterround', 'Teachercontroller@enterround');
    // This Route Returns All Active Baskets In A View For The Teacher
    Route::get('baskets', 'Teachercontroller@getbasketsview');
    // Route For Showing A Specific Basket To The Teacher
    Route::post('basket/{basket}', 'Teachercontroller@getbasket');
    // Route For Updating/Changing Basket Score By The Teacher
    Route::post('basketupdate/{basket}', 'Teachercontroller@basketupdate');
    /*
    Route::get('teacherEntertoGame/{classindividual}', function($studentinfo){
        return view('teacher.teacherStart', ['id' => $studentinfo->personalID]);
    });*/

    Route::get('startgame/{stdID}', function ($stdID) {
        Event::fire(new \App\Events\prestartCycling());
        //dd('here');
        $api = new \App\Http\Controllers\api();
        return view('teacher.teacherMain', ['id' => $stdID, 'info' =>
                           $api->attributes($stdID)]);
    });

    /*
    * Inner Routes Controller Amirsorouri00
    */
    Route::get('/teacher/{stdID}', ['as' => 'client2', function (Request $request, $stdID) {
        //dd($request->stdID);
        $api = new \App\Http\Controllers\api();
        return view('teacher.teacherMain', ['id' => $stdID, 'info' =>
                           $api->attributes($stdID)]);
        //return $stdID;
        return view('client', ['stdID' => $request->stdID]);
    }]);

    Route::get('/data', 'amircontroller@test');
    Route::get('/cycling', 'amircontroller@cycle');
    Route::post('forceExit', 'api@userForceExit');

    Route::post('posttest', function () {
        return 'amirposttest';
    });
    //Route::get('/client', ['stdID' => 'stdID']);

    Route::get('fire', function (Request $request) {
        // this fires the event
        //  event(new App\Events\socketio());
        //$rt= $request->getContent();
        $data = $request->json()->all();
        // Log::debug($request);
        // $phpArray = json_decode($data,true);
        $name = $data['name'];
        $coach_uuid = $data['coach']['uuid']; // works now !!!
        $category_uuid = $data['category']['uuid']; // works now!!!
        $ee = '{"af":"34"}';
        $df = json_decode($ee, JSON_HEX_APOS);
        //return $df['af'];
        $df = json_decode($ee, true);
        //return $df['af'];/*
        /*$ee='{'af':34}';
        return $df['af'];
        $name = $request->input('data');
        $redis = Redis::connection();
        $redis->publish('log',json_decode($df));
*/
        return "event fired";
    });

    Route::get('/test', function () {
        // this checks for the event
        return view('test');
    });

    Route::post('l', function () {
        $basket = App\Basket::where('basketID', '4VeF64t')->firstOrFail();
        $basket->basketStatus = 'amir';
        $basket->save();
        return view('test');
    });


    /*
     * Mohsen Routes
     * */


    Route::get('redistime', function () {
        $r = Redis::connection();
        $l = collect();
        $l->put('roundnumber', 1);
        $ttt = Carbon::now();
        $l->put('time', $ttt);
        $r->sadd('round', json_encode($l));
        $l = collect();
        $l->put('roundnumber', 2);
        $l->put('time', $ttt);
        $carbonnow = Carbon::now();
        $r->sadd('round', json_encode($l));
        Redis::set('time', $carbonnow);
        return 1;
    });

    Route::get('template', function () {
        return view('main')->with(['err' => 'sfsdfsdfsf']);
    });

    Route::post('Ajtest', function (Request $req) {
        $user = \App\Studentinfo::all()->where('participantID', $req['studentid'])->first();
        $user->gradeH = $req['num2'];
        $user->gradeL = $req['num1'];//31523
        //$user->roundNumber = $req['roundnumber'];
        $user->save();
//        $allusersRound = \App\Studentinfo::all()->where('roundnumber', $req->roundnumber);
//        foreach ($allusersRound as $u) {
//            if ($u->gradeH == -1 || $u->gradeL == -1) {
//                return 1;//
//            }
//        }
//        //fire to continue cycling
//        Event::fire(new \App\Events\Cycling($req->roundnumber));
//
//        return $req;
        return 1;
    });

    Route::get('mostafa', function () {
        $client = new Client();
        $response = $client->post('http://bit.com:8585/', [
            'json' => ['foo' => 'bar']
        ]);

        return $response;
    });

    Route::get('startcycling', function () {
        Event::fire(new \App\Events\prestartCycling());
        //Event::fire(new \App\Events\startCycling());
    });

    Route::get('startround/{num}', function ($num) {

        Event::fire(new \App\Events\Cycling($num));
        return $num;
    });

    //test socket
    Route::get('sockettest', function () {
        /*  $redis = Redis::connection();
          $list = collect(['users' => [['username' => 'hossein', 'operation' => 1], ['username' => 'mohsen', 'operation' => 0]]]);
          //    $list = collect(['usernames' => ['mohsen', 'ali', 'amir']]);
          $redis->publish('message', $list);
          return $list->toJson();*/
        $redis = Redis::connection();
        $redis->publish('goToquestionpart', 'MetR2I7');
        $redis = Redis::connection();
        $zaman = Carbon::now();
        Redis::set('lastroundtime', $zaman);

        return dd($zaman);
    });


    Route::post('telegramRange', function (Request $request) {
//dd($request);
try{
        $request= $request->json()->all();

        $user = \App\Studentinfo::all()->where('participantID', $request['username'])->first();
        $user->gradeH = $request['range']['max'];
        $user->gradeL = $request['range']['min'];//31523
        $user->save();
        return 'ok';
    }
    catch (Exception $e) {
return 'notok';
    }    //Todo save and check
    });

    Route::post('androidRange',function(Request $request){
        
         $user = \App\Studentinfo::all()->where('participantID', $request['username'])->first();
        $user->gradeH = $request['range']['max'];
        $user->gradeL = $request['range']['min'];//31523
        $user->save();
        $oljson=collect();
        $oljson->put('status','ok');
        return $oljson->toJson();
       
      /// return json_encode($oljson);
    });
   /* Route::post('androidRange',function(){
        return 1;
        Request $request
         $user = \App\Studentinfo::all()->where('participantID', $request['username'])->first();
        $user->gradeH = $request['range']['max'];
        $user->gradeL = $request['range']['min'];//31523
        $user->save();
        return 'ok';
    });
*/
    Route::get('mahditest', function (Request $request) {
        Event::fire(new \App\Events\Cycling(0));
        return 1;
    });

    Route::get('start',function(){
       Event::fire(new \App\Events\startCycling());

    });

    Route::get('startbazi',function(){
        \Event::fire(new \App\Events\prestartCycling1());
    });

    Route::get('cheackSet', function () {
        $r = Redis::connection();
        $l = collect();
        $l->put('roundnumber', 1);
        $l->put('time', 0);
        $r->sadd('round', json_encode($l));

    });

    Route::get('splash', function () {
        return view('splash');
    });

    Route::auth();

    Route::get('infosec', function () {

      try { 
       $jsond='{"data":{"basket":{"basketID":"rzthmDW","examID":"1","id":2475,"questionerID":"9330033","qPlatform":"web","responderedID":"9327303","rPlatform":"web","questionID":0,"basketScore":2,"basketStatus":"Active","flag":0,"correctness":0,"respondentlist":[]},"question":{"status":"ok","questions":[{"id":40,"title":"Concepts and Phenomena","content":"کدام یک از گزینه های زیر توصیف کننده ی Concept است؟","options":[{"option_id":53,"content":"توصیف ویژگی های Phenomena","answer":1},{"option_id":54,"content":"دارای نام، هدف و مدل","answer":0},{"option_id":55,"content":"توصیف ویژگی های view","answer":0},{"option_id":56,"content":"دارای نام، هدف و کلاس","answer":0}]}]},"answer":{"userAnswerId":54,"userAnswer":"دارای نام، هدف و مدل","result":0},"protest":"yes"},"ticket":"justforfun"}';      
        
            $client = new Client();
            //todo json check!!!

            $response = $client->request('POST', 'http://judge.intellexa.me/rfj/', [
                'body' => '[json_decode($jsond)]'
            ]);

            return $response->getBody();
        } catch (Exception $e) {
return false;
        }
    
       
        ;
    });


});
//Route::post('posttest', 'amircontroller@posttest');
