<?php
namespace NCATesting\controller;
use App\Controller\DefaultController;
use NCATesting\UnitTester;

class defaultCest
{
    private $fixture;

    public function _before(UnitTester $I)
    {
        $this->fixture = new DefaultController();
    }

    public function getSourceParamReturnWebsiteDefault(UnitTester $I)
    {
        $methodReturn = $I->getMethodReturn($this->fixture,'getSourceParam', '');
        $I->assertContains('aff=website', $methodReturn);
    }
}
