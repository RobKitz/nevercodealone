<?php
namespace NCATesting\navigation;
use NCATesting\AcceptanceTester;
use NCATesting\Helper\Config;
use NCATesting\Page\startpage;

class mainCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->waitForElement('h1');
    }

    // tests
    public function allItemsAreTargetBlank(AcceptanceTester $I, startpage $startpage, Config $helperConfig)
    {
        $url = $helperConfig->getUrlFromConfigWebdriver('url');

        $items = $I->grabMultiple($startpage::$navMainLeft, 'href');
        $items = array_merge($items, $I->grabMultiple($startpage::$navMainRight, 'href'));

        $itemsTargets = $I->grabMultiple($startpage::$navMainLeft, 'target');
        $itemsTargets = array_merge($itemsTargets, $I->grabMultiple($startpage::$navMainRight, 'target'));

        foreach ($items as $key => $item) {
            if(strpos($item, $url) === false) {
                $I->assertEquals('_blank', $itemsTargets[$key], 'Item blank: ' . $item);
            } else {
                $I->assertEquals('', $itemsTargets[$key], 'Item no blank: ' . $item);
            }
        }
    }
}
