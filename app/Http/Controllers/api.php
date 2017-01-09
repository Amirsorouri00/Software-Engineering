<?php
/**
 * Created by PhpStorm.
 * User: hkafi
 * Date: 12/25/2016
 * Time: 12:29 AM
 */

namespace App\Http\Controllers;

use App\Http\Controllers\amircontroller;
//use App\Http\Requests\Request;
use App\Studentinfo;
use App\User;
use App\Basket;
use Symfony\Component\HttpFoundation\ParameterBag;
use Illuminate\Http\Request;
use App\Http\Requests;
//use Illuminate\Support\Facades\Request;
class api extends Controller
{
    public function volunteer(Request $request)
    {
        $jj=json_decode($request);

        $rr= $request->json();
        $basket = new Basket();
        $basket-> basketID = $rr-> all()['data']['basket']['basketID'];
        $basket-> examID= $rr-> all()['data']['basket']['examID'];
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