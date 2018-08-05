<?php
namespace NCATesting\controller;
use App\Controller\DefaultController;
use NCATesting\UnitTester;
use Mockery as m;

class defaultCest
{
    private $fixture;

    public function _before(UnitTester $I)
    {
        $this->fixture = new DefaultController();
    }

    public function getSourceParamReturnWebsiteDefault(UnitTester $I)
    {
//        $request->query->get('aff');
        $response = m::mock('Symfony\Component\HttpFoundation\Request');
        $response->shouldReceive('query->get')->once()->andReturn('testiy');

        $methodReturn = $I->getMethodReturn($this->fixture,'getSourceParam', $response);
        $I->assertContains('aff=website', $methodReturn);
    }
}
