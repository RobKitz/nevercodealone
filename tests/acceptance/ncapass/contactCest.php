<?php
namespace NCATesting\ncapass;
use NCATesting\AcceptanceTester;

class contactCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/nca-paas-startup/');
        $I->wait(5);
        $I->waitForElement('#setting > i');
    }

    // tests
    public function openContactFormAndSentWithValidData(AcceptanceTester $I)
    {
        $inputData = [
            'name' => 'Roland',
            'email' => 'rg-' . time() . '@gmail.com',
            'message' => 'Testify right here'
        ];

        $I->click('#setting > i');
        $I->wait(1);
        $I->fillField('#name', $inputData['name']);
        $I->fillField('#email', $inputData['email']);
        $I->fillField('#phone', '112');
        $I->fillField('#message', $inputData['message']);

        $I->click('#frm_contact > div > div.button > button');
        $I->waitForText('Danke wir melden uns');

        $inputData['message'] = 'email|112|Testify right here';

        $I->seeInDatabase(
            'message',
            $inputData
        );
    }
}
