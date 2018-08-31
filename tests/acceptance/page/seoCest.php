<?php
namespace NCATesting\page;
use NCATesting\AcceptanceTester;

class seoCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->waitForElement('h1');
    }

    public function hasTitle(AcceptanceTester $I)
    {
        $meta = $I->getMeta();
        $I->assertNotEmpty($meta['title']);
    }
}
