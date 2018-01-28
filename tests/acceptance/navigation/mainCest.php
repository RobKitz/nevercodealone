<?php
namespace NCATesting\navigation;
use NCATesting\AcceptanceTester;
use NCATesting\Page\startpage;

class mainCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->waitForElement('h1');
    }

    // tests
    public function allItemsAreTargetBlank(AcceptanceTester $I, startpage $startpage)
    {
        $noBlankItems = ['home'];

        $items = $I->grabMultiple($startpage::$navMainLeft);
        $items = array_merge($items, $I->grabMultiple($startpage::$navMainRight));

        $itemsTargets = $I->grabMultiple($startpage::$navMainLeft, 'target');
        $itemsTargets = array_merge($itemsTargets, $I->grabMultiple($startpage::$navMainRight, 'target'));

        foreach ($items as $key => $item) {
            // Selector gets for each an empty value - no beer could fix this
            if($item !== '') {
                if(in_array(strtolower($item), $noBlankItems)) {
                    $I->assertEquals('', $itemsTargets[$key], 'Item: ' . $item);
                } else {
                    $I->assertEquals('_blank', $itemsTargets[$key], 'Item: ' . $item);
                }
            }
        }
    }
}
