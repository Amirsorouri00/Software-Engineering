<?php

use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class insEnteringTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
        $enteredPersonRequest = collect(['data' => ['person' => ['personalID' => '1274568', 'role' => 'instructor', 'classID' => '1111111'],
            "ticket" => "volunteerRespondUserTicket"]])->toJson();
        $enteredPersonRequest = json_decode("{'data':{'person':{'personalID':'1274568','role':'instructor','classID':'1111111'},'ticket':'volunteerRespondUserTicket'}}");
        $enteredPersonRequest->json()->all();
        $this->assertEquals('1274568', $enteredPersonRequest);
    }
}
