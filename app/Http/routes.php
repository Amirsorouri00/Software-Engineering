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

Route::group(['middleware' => ['web']], function () {

    Route::get('/', function () {
        return view('welcome');
    })->middleware('guest');
    Route::get('test', 'amircontroller@matchwithperiod');
    Route::get('/tasks', 'TaskController@index');
    Route::delete('/task/{task}', 'TaskController@destroy');

    //amirsorouri00
    Route::get('/data', 'amircontroller@test');
    Route::get('/cycling', 'amircontroller@cycle');

    Route::post('/entertogame', 'api@getEnteredPerson');

    Route::post('forceExit', 'api@userForceExit');

    Route::post('volunteerExit', 'api@volunteerExitRequest');

    Route::post('/getVolunteers', 'api@getVolunteersBasket');

    Route::post('/getObjectedBasket', 'api@getObjectedToScoreBasket');

    Route::post('/getObjectionResult', 'api@getObjectedToScoreBasketResult');

    Route::post('/questionPartResult', 'api@questionPartResult');

    Route::post('volunteerResult', 'api@volunteerResult');

    Route::post('posttest', function () {
        return 'amirposttest';
    });
    //Route::get('/client', ['stdID' => 'stdID']);
    Route::get('/client/{stdID}', ['as' => 'client', function (Request $request, $stdID) {
        //dd($request->stdID);
        return $stdID;
        return view('client', ['stdID' => $request->stdID]);
    }]);

    Route::get('fire', function () {
        // this fires the event
        event(new App\Events\socketio());
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

    //Teacher part //Mohsen
    Route::get('baskets', 'Teachercontroller@getbasketsview');
    Route::get('enterround', 'Teachercontroller@enterround');
    Route::get('basket/{basket}', 'Teachercontroller@getbasket');
    Route::get('teacherlogin', 'Teachercontroller@login');
    Route::post('basketupdate/{basket}', 'Teachercontroller@basketupdate');
    //Route::get('')
    /*
    Route::get('teacherEntertoGame/{classindividual}', function($studentinfo){
        return view('teacher.teacherStart', ['id' => $studentinfo->personalID]);
    });*/
    Route::post('teacherEntertoGame/{studentinfo}', 'Teachercontroller@teacherEntertoGame');
    Route::get('startgame', function(){
        Event::fire(new \App\Events\prestartCycling());
    });

    // test
    Route::get(
        'redistime', function () {
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
//

        $user = \App\Studentinfo::all()->where('participantID', $req['studentid'])->first();
        $user->gradeH = $req['num2'];
        $user->gradeL = $req['num1'];//31523
        $user->roundNumber = $req['roundnumber'];
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

        
       Event::fire(new \App\Events\startCycling());


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

    Route::get('/main/{userid}', function ($userid) {

$api= new \App\Http\Controllers\api();
       // return $api->attributes($userid);

        return view('main')->with('info', $api->attributes($userid));
    });
    Route::post('telegramRange', function (Request $request) {

        
       
        $user = \App\Studentinfo::all()->where('participantID', $request['username'])->first();
        $user->gradeH = $request['range']['max'];
        $user->gradeL = $request['range']['min'];//31523
        $user->save();


        return 'ok';

        //Todo save and cheack

    });
    Route::get('splash', function () {
        return view('splash');
    });
    Route::auth();
    Route::get('parttest', function () {

        $jsond = '{
  "data": {
    "basketsArray": [
      {
        "basket": {
          "basketID" : 2,
          "examID" : 8,
          "questionerID" : 9330033,
          "qPlatform" : "web",
          "responderedID" : 9323613,
          "rPlatform" : "web",
          "basketScore" : 2

        }
      },
      {
        "basket": {
          "basketID" : 2,
          "examID" : 8,
          "questionerID" : 9334433,
          "qPlatform" : "telegram",
          "responderedID" : 9323620,
          "rPlatform" : "web",
          "basketScore" : 2
        }
      },
      {
        "basket": {
          "basketID" : 2,
          "examID" : 8,
          "questionerID" : 9334440,
          "qPlatform" : "web",
          "responderedID" : 9323622,
          "rPlatform" : "telegram",
          "basketScore" : 2
        }
      }
    ]
  },
  "ticket": "volunteerRespondUserTicket"
}';
//        $client = new Client();
//        $response = $client->request('POST','http://172.17.10.252:2000/getPartBaskets', [
//            'json' =>  [$jsond]
//        ]);
        try {
            $client = new Client();
            $response = $client->request('POST', 'http://172.17.10.252:2000/getPartBaskets', [
                'json' => [json_decode($jsond)]
            ]);
        } catch (Exception $e) {

        }

        // $client = new Client();

//        $client = new Client([
//            // Base URI is used with relative requests
//            'base_uri' => 'http://httpbin.org',
//            // You can set any number of default request options.
//            'timeout' => 2.0,
//        ]);
//
//  $response = $client->post('http://172.17.10.252:2000/getPartBaskets', [
//            'json' => [$jsond]
//        ]);

        //$response = $client->get('http://172.17.10.252:2000/getPartBaskets');

//        $request = $client->post('http://172.17.10.252:2000/getPartBaskets', array(
//            'content-type' => 'application/json'
//        ), array());
//        $request->setBody($jsond); #set body!
//        $response = $request->send();
//        return $response;


        //  $res=   $client->request('POST', '/dfg', ['json' => [$jsond]]);


        return $response->getHeader();
    });
    Route::get('mahditest', function (Request $request) {
        Event::fire(new \App\Events\Cycling(0));
        return 1;
    });

    Route::get('start',function(){
       Event::fire(new \App\Events\startCycling());

    });
    Route::get('cheackSet', function () {
        $r = Redis::connection();
        $l = collect();
        $l->put('roundnumber', 1);
        $l->put('time', 0);
        $r->sadd('round', json_encode($l));

    });

});



//Route::post('posttest', 'amircontroller@posttest');

