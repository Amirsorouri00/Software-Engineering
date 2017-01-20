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
    Route::post('/volun', 'api@getVolunteersBasket');
    Route::post('/entertogame', 'api@getEnteredPerson');
    Route::post('/objection', 'api@getObjectedToScoreBasket');
    Route::post('/objectres', 'api@getObjectedToScoreBasketResult');
    Route::post('/qresult', 'api@questionPartResult');
    //Route::get('/client', ['stdID' => 'stdID']);
    Route::get('/client/{stdID}', ['as' => 'client',function(Request $request,$stdID ){
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

    Route::post('l', function(){
       $basket = App\Basket::where('basketID', '4VeF64t')->firstOrFail();
       $basket->basketStatus = 'amir';
       $basket->save();
       return view('test');
    });

    //hossein
    Route::post('/EnterAndExit', 'api@EnterAndExit');
    Route::post('/task', 'TaskController@store');
    Route::post('/volunteer', 'api@volunteer');
    Route::get('/Judge', 'api@Judge');

    //Teacher part //Mohsen
    Route::get('baskets', 'Teachercontroller@getbasketsview');
    Route::get('enterround', 'Teachercontroller@enterround');
    Route::get('basket/{basket}', 'Teachercontroller@getbasket');
    Route::get('teacherlogin', 'Teachercontroller@login');
    Route::post('basketupdate/{basket}', 'Teachercontroller@basketupdate');


    // test semantic
    Route::get('template', function () {
        return view('main');
    });

    Route::post('Ajtest',function(Request $req){
     $user=  \App\Studentinfo::all()->where('participantID',$req->studentid)->first();
       $user->gradeH=$req->num2;
       $user->gradeL=$req->num1;

        $user->roundNumber=$req->roundnumber;
        $user->save();
        //
        $allusersRound=\App\Studentinfo::all()->where('roundnumber',$req->roundnumber);
        foreach($allusersRound as $u)
        {
            if($u->gradeH==-1 || $u->gradeL==-1)
            {
                return 1;//
            }
        }
        //fire to continue cycling
         Event::fire(new \App\Events\Cycling($req->roundnumber));

        return $req;
    });
////?!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!
    Route::get('semantic', function () {
        return 2;
    });
    ////?!!!!!!!!!!!!!!!!!!!!!!!!!!
    //test socket
    Route::get(/**
     * @return string
     */
        'sockettest', function () {
        $redis = Redis::connection();
        $list = collect(['users' => [['username' => 'hossein', 'operation' => 1], ['username' => 'mohsen', 'operation' => 0]]]);
        //    $list = collect(['usernames' => ['mohsen', 'ali', 'amir']]);
        $redis->publish('message', $list);
        return $list->toJson();

    });


    Route::auth();

});

//Route::post('posttest', 'amircontroller@posttest');

