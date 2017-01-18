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
        $list = collect(['users' => [['username' => 'hossein', 'operation' => 1], ['username' => 'mohsen', 'operation' => 0]]]);

        return User::all()->first() ;
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

