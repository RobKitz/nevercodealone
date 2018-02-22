<?php
namespace NCATesting\pageobjects;
use NCATesting\AcceptanceTester;

class contactCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $contactDiv = '.tz-contact-content';
        $I->waitForElement($contactDiv);
        $I->scrollTo($contactDiv);
    }

    // tests
    public function checkValidFormSending(AcceptanceTester $I)
    {
        $time = microtime();

        $name = 'test';
        $email = 'test' . $time . '@ify.com';
        $message = 'CC message:' . $time;

        $messagePost = [
            'name'    => $name,
            'email'   => $email,
            'message' => $message
        ];

        $I->fillField('#name', $name);
        $I->fillField('#email', $email);
        $I->fillField('#message', $message);
        $I->click('#send');

        $I->waitForText('Danke wir melden uns');

        $I->seeNumRecords(1, 'message', $messagePost);
    }
}
