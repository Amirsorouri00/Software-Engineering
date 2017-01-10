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

Route::group(['middleware' => ['web']], function () {

    Route::get('/', function () {
        return view('welcome');
    })->middleware('guest');

    Route::get('/tasks', 'TaskController@index');
    Route::delete('/task/{task}', 'TaskController@destroy');



    //hossein
    Route::post('/EnterAndExit','api@EnterAndExit');
    Route::post('/task', 'TaskController@store');
    Route::post('/volunteer','api@volunteer');
    Route::get('/Judge','api@Judge');

    Route::auth();

});


//amir
Route::get('/data', 'amircontroller@test');
Route::get('/cycling', 'amircontroller@cycle');
Route::post('/volun', 'api@getVolunteersBasket');
Route::post('/entertogame', 'api@getEnteredPerson');