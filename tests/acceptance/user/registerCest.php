<?php
namespace NCATesting\user;
use NCATesting\AcceptanceTester;

class registerCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/vorverkauf/');
        $I->waitForElement('h1');
    }

    public function validUser(AcceptanceTester $I)
    {
        $time = time();
        $subscribers = [
            [
                'name' => 'Testify' . $time,
                'email' => 'test' . $time . '@ify.com'
            ]
        ];

        foreach ($subscribers as $subscriber) {
            $I->fillField('#name', $subscriber['name']);
            $I->fillField('#email', $subscriber['email']);
            $I->click('.btn-default');
            $I->waitForText('Danke für die Anmeldung.');

            $I->seeNumRecords(1, 'fos_user', [
                'email' => $subscriber['email'],
                'name'  => $subscriber['name']
            ]);

            $I->reloadPage();
        }
    }
}
