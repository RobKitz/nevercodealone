<?php
namespace NCATesting\page;
use NCATesting\AcceptanceTester;

class metaCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->waitForElement('h1');
    }

    // tests
    public function metaContentImageHasStatusOk(AcceptanceTester $I)
    {
        $image = $I->getMeta(['twitter:image'])['twitter:image'];
        $status = $I->getCurlStatusByUrl($image);
        $I->assertSame(200, $status);
    }
}
