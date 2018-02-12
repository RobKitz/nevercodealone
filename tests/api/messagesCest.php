<?php
namespace AppBundle;
use NCATesting\ApiTester;

class messagesCest
{
    public function addMessageWithValidNameAndEmail(ApiTester $I)
    {
        $time = time();

        $name = 'test';
        $email = 'test' . $time . '@ify.com';
        $message = 'CC message:' . $time;

        $messagePost = [
            'name'    => $name,
            'email'   => $email,
            'message' => $message
        ];


        $I->haveHttpHeader('Content-Type', 'application/json');
        $I->sendPOST(
            '/api/messages',
            json_encode($messagePost)
        );

        $I->seeResponseIsJson();

        $response = json_decode($I->grabResponse(), true);

        $I->assertEquals('doRegistration', $response);
        $I->seeResponseCodeIs(200);
    }
}
