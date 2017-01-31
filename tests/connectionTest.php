<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;
use Exception;
use Goutte\Client;
use Faker\Factory as Faker;
use App\Basket;

class connectionTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    /*public function testExample()
    {
        $this->assertTrue(true);
    }*/

    /*  public function testcycling(){
        Event::fire(new \App\Events\Cycling());
        $this->get('/test')
            ->seePageIs('test')
            ->see('mohsen')
            ->seeInDatabase('1', '1');
        $this->visit('/register')
            ->type('Taylor Otwell', 'name')
            ->type('taylor@laravel.com', 'email')
            ->type('secret', 'password')
            ->type('secret', 'password_confirmation')
            ->press('Register')
            ->seePageIs('/tasks')
            ->seeInDatabase('users', ['email' => 'taylor@laravel.com']);
    }*/

    /*$response = $this->json(
           'POST', //Method
           '/volun', //Route
           ['key1' => 'value1', 'key2' => 'value2'], //JSON Body request
           [$volunteerRequest]           // Extra headers (optional)
       )->seeStatusCode(200)->seePageIs('test')->see('amir');*/

    /*
        public function testGetEnteredPerson(){
            $enteredPersonRequest = collect(['data' => ['person' => ['personalID' => '1533574', 'classID' => '7HhRE7U'],
                "ticket" => "volunteerRespondUserTicket"]])->toJson();
            try {
                //echo $enteredPersonRequest;
                //$this->post('/entertogame', [$enteredPersonRequest])->seeStatusCode(200);
                //$client = static::createClient();
                //$crawler = $client->request()
                $headers = [];
                $headers['CONTENT_TYPE'] = 'application/json';
                $headers['Accept'] = 'application/json';
                $server = $this->transformHeadersToServerVars($headers);
                $response = $this->call('post', '/entertogame',[],[],[],$server, $enteredPersonRequest);
                //$post = $this->action('POST', '/entertogame', null, array(), array(), array(), $enteredPersonRequest);
                //$this->assertTrue($this->client->getResponse()->isOk());
                //$this->assertResponseOk();
                $u = \GuzzleHttp\json_decode($enteredPersonRequest, true);
                //print_r($u['data']);
                $this->seeInDatabase('classindividuals', ['personalID' => $u['data']['person']['personalID'], 'isPresent' => 1, 'isActive' => 1]);
                $this->seeInDatabase('studentinfos', ['participantID' => $u['data']['person']['personalID'], 'roundNumber' => 0, 'individualStatus' => true]);
                $this->seePageIs('/test')->assertViewHas('amir');
                //$this->post('/entertogame',[$enteredPersonRequest])->assertRedirectedTo('/test');
            }catch(\Exception $e){
                echo $e;
            }
        }
    */

    /*
    public function testVolunteerGetBasket(){
        $volunteerRequest = collect(['data' => ['basketsArray' => [['basket' => 'T1cuEH0',"respondentlist"=> ['rHfRRzm','rHfRRzm','UiE53Oz']]
            ,['basket' => 'azOvhNP',"respondentlist"=> ['H2gtkLt','faPRg2N','aRDuQH2']]
            ,['basket' => 'nOjkcY8',"respondentlist"=> ['qTKRKgZ','8AJiPsP','ga1Cew8']]]
            ,'ticket' => "volunteerRespondUserTicket"]])->toJson();

        $baskettmp = Basket::where('basketStatus', '=', 'Active')->get()->take(3);
        $i = DB::table('classindividuals')->join('studentinfos','personalID','=','participantID')
        ->where('isPresent', 1)->where('individualStatus', false)->take(9)->get(['personalID']);
        //print_r($baskettmp);
        //echo $i;
        //print_r ($i[0]);
        $arr = collect();
        $count = 0;
        foreach($baskettmp as $tmp){
            $arr->push(['basket' => $tmp, 'respondentlist' => [$i[$count]->personalID, $i[$count+1]->personalID, $i[$count+2]->personalID]]);
            $count+=3;
        }
        $final = collect(['data' => ['basketsArray' => $arr], 'ticket' => 'volunteerRespondUserTicket']);
        //echo $final['data']['basketsArray'];
        //return 1;


        //$this->post('/volun',[$volunteerRequest])->seeStatusCode(200);
        $headers = [];
        $headers['CONTENT_TYPE'] = 'application/json';
        $headers['Accept'] = 'application/json';
        $server = $this->transformHeadersToServerVars($headers);
        //echo '1';
        $response = $this->call('post', '/volun',[],[],[],$server, json_encode($final));
        //echo '2';

        try{
            $baskets = $arr;
            //echo '3';
            foreach($baskets as $basket){
                //echo '4';
                //echo $basket['basket']['basketID'];
                $this->seeInDatabase('baskets',['basketID' => $basket['basket']['basketID'], 'basketStatus' => 'deActive']);
                try{
                    $basketOriginal = \App\Basket::where('basketID', $basket['basket']['basketID'])->firstOrFail();
                    $respondents = $basket['respondentlist'];
                    foreach($respondents as $respondent){
                        $this->seeInDatabase('baskets', ['responderedID' => $respondent, 'questionerID' => $basketOriginal->questionerID, 'basketStatus' => 'Active',
                            'flag' => '1']);
                    }
                }
                catch(\Exception $e){
                    echo $e;
                }
            }
        }catch(\Exception $e){
            echo $e;
        }
        //$u = \GuzzleHttp\json_decode($final['data']['basketsArray'], true);
    }*/

    /*
    public function testGetObjetedToScoreBasket(){
        $baskettmp = Basket::where('basketStatus', 'Active')->get()->take(3);
        //echo $baskettmp;
        $var = DB::table('baskets')->join('studentinfos','participantID', '=', 'responderedID')
                    ->join('classindividuals', 'personalID', '=', 'participantID')
                    ->where('basketStatus', 'Active')->where('isPresent', 1)
                    ->take(3)->get(['studentinfos.*', 'baskets.*']);

        //print_r( $var);
        //return 1;
        foreach($var as $tmp){
            //print_r( $tmp->basketID);
            //return 1;
            $b = Basket::where('basketID', $tmp->basketID)->firstOrFail();
            $request = collect(['data' => ['basket' => $b], 'ticket' => 'volunteerRespondUserTicket']);
            echo $request;
            $beforeBasketScore = $tmp->basketScore;
            $responder = \App\Studentinfo::where('participantID', $tmp->responderedID)->firstOrFail();
            $exam = \App\Exam::where('examID', $tmp->examID)->firstOrFail();
            //echo $exam;
            //echo $responder;
            //echo $beforeBasketScore;
            //return 1;
            $beforeScore = $responder->finalScore;
            $headers = [];
            $headers['CONTENT_TYPE'] = 'application/json';
            $headers['Active'] = 'application/json';
            $server = $this->transformHeadersToServerVars($headers);

            $response = $this->call('post', '/objection', [], [], [], $server, $request);
            //return 1;
            $this->seeInDatabase('studentinfos',['participantID' => $tmp->responderedID, 'finalScore' => $beforeScore - $exam->questionScore]);
            $this->seeInDatabase('baskets', ['basketID' => $tmp->basketID, 'basketScore' => $beforeBasketScore + $exam->questionScore]);
            //$this->seePageIs('/l')->seeStatusCode(200);
        }
    }*/

    /*
    public function testQuestionPartResult(){
        $var = DB::table('baskets')->join('studentinfos','participantID', '=', 'responderedID')
            ->join('classindividuals', 'personalID', '=', 'participantID')
            ->where('basketStatus', 'Active')->where('isPresent', 1)
            ->take(3)->get(['studentinfos.*', 'baskets.*']);

        //print_r( $var);
        //return 1;
        foreach($var as $tmp){
            //print_r( $tmp->basketID);
            //return 1;
            $b = Basket::where('basketID', $tmp->basketID)->firstOrFail();
            $request = collect(['data' => ['basket' => $b], 'ticket' => 'volunteerRespondUserTicket']);
            //echo $request;
            $beforeBasketScore = $tmp->basketScore;
            $responder = \App\Studentinfo::where('participantID', $tmp->responderedID)->firstOrFail();
            $exam = \App\Exam::where('examID', $tmp->examID)->firstOrFail();
            //echo $exam;
            //echo $responder;
            //echo $beforeBasketScore;
            //return 1;
            $beforeScore = $responder->finalScore;
            $headers = [];
            $headers['CONTENT_TYPE'] = 'application/json';
            $headers['Active'] = 'application/json';
            $server = $this->transformHeadersToServerVars($headers);
            $response = $this->call('post', '/qresult', [], [], [], $server, $request);
            //echo 'here';
            //return 1;
            $this->seeInDatabase('studentinfos',['participantID' => $tmp->responderedID, 'finalScore' => $beforeScore + $tmp->basketScore]);
            $this->seeInDatabase('baskets', ['basketID' => $tmp->basketID, 'basketStatus' => 'deActive']);
            //$this->seePageIs('/l')->seeStatusCode(200);
        }
    }*/

    /*
    public function testObjectionResult(){
        $var = DB::table('baskets')->join('studentinfos','participantID', '=', 'responderedID')
            ->join('classindividuals', 'personalID', '=', 'participantID')
            ->where('basketStatus', 'Active')->where('isPresent', 1)
            ->take(3)->get(['studentinfos.*', 'baskets.*']);

        $se = factory('alaki', function(Faker\Generator $faker){
            return $faker->randomElements(['accepted', 'unaccepted']);
        });
        //print_r( $var);
        //return 1;
        foreach($var as $tmp){
            //print_r( $tmp->basketID);
            //return 1;
            $faker = Faker::create();

            $b = Basket::where('basketID', $tmp->basketID)->firstOrFail();
            $request = collect(['data' => ['basket' => $b], 'Judge' =>$faker->randomElement(['accepted','unaccepted']) , 'ticket' => 'volunteerRespondUserTicket']);
            echo $request;
            //return 1;

            $beforeBasketScore = $tmp->basketScore;
            $responder = \App\Studentinfo::where('participantID', $tmp->responderedID)->firstOrFail();
            $exam = \App\Exam::where('examID', $tmp->examID)->firstOrFail();
            //echo $exam;
            //echo $responder;
            //echo $beforeBasketScore;
            //return 1;
            $beforeScore = $responder->finalScore;
            $headers = [];
            $headers['CONTENT_TYPE'] = 'application/json';
            $headers['Active'] = 'application/json';
            $server = $this->transformHeadersToServerVars($headers);
            $response = $this->call('post', '/objectres', [], [], [], $server, $request);
            if($request['Judge'] == 'accepted'){
                $this->seeInDatabase('studentinfos',['participantID' => $tmp->responderedID, 'finalScore' => $beforeScore + $tmp->basketScore]);
                $this->seeInDatabase('baskets', ['basketID' => $tmp->basketID, 'basketStatus' => 'deActive']);
                echo 'accepted';
            }
            else{
                $this->seeInDatabase('baskets', ['basketID' => $tmp->basketID, 'basketStatus' => 'volunteer']);
                echo 'unaccepted';
            }
            //echo 'here';
            //return 1;
            //$this->seePageIs('/l')->seeStatusCode(200);
        }
    }*/

    /*
        public function test(){
            $enteredPersonRequest = collect(['data' => ['person' => ['personalID' => '1534574', 'classID' => '7HhRE7U'],
                "ticket" => "volunteerRespondUserTicket"]]);
            $headers = [];
            $headers['CONTENT_TYPE'] = 'json/application';
            $headers['Active'] = 'json/application';

            $client = new client();
            //$server = $this->transformHeadersToServerVars($headers);
            //$response = $this->post('/entertogame', $headers, $headers)->seePageIs('/test');
            $queryParams = [
                'foo=1',
                'bar=2',
                'bar=3',
                'baz=4',
            ];
            //$content = implode('&', $queryParams);
            $crawler = $client->request('POST', 'software:81/entertogame', [], [], ['CONTENT_TYPE' => 'json/application'], $enteredPersonRequest);
            $i = $client->followRedirect();
            $message = $crawler->filter('.success-message');
            $this->assertCount(1, $message);
            $crawler = $this->client->request('post', '/entertogame', ['test' => 'testak']);
            $this->assertResponseStatus(302);

            $this->assertCount(1, $message);
            //$response->seeStatusCode(200)->seePageIs('/test');
        }
    */
}
