<?php
namespace NCATesting\seo;
use NCATesting\AcceptanceTester;

class startpageCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->waitForElement('h1');
    }

    public function titleContainsOpenSource(AcceptanceTester $I)
    {
        $I->canSeeInTitle('Open Source');
    }
}
