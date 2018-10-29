<?php
namespace NCATesting\navigation;
use NCATesting\AcceptanceTester;
use NCATesting\Helper\Acceptance as AcceptanceHelper;
use NCATesting\Helper\Config;
use NCATesting\Page\startpage;

class mainCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnPage('/');
        $I->waitForElement('h1');
    }

    public function subnavigationFirstLinkIsNavigationLink(AcceptanceTester $I, startpage $startpage, AcceptanceHelper $acceptanceHelper)
    {
        $items = $this->getItems($I, $startpage);

        foreach ($items as $key => $url) {
            $subNavigationFirstItem = 'body > header > div > div > div > nav > ul > li:nth-child(' . ($key + 1) . ') > ul > li:nth-child(1) > a';
            if ($acceptanceHelper->seePageHasElement($subNavigationFirstItem)) {

                $href = $I->grabAttributeFrom($subNavigationFirstItem, 'href');
                $I->assertEquals($url, $href, 'URL main nav equals first item subnav.');
            }
        }

    }

    public function headerIsAlwaysVisible(AcceptanceTester $I)
    {
        $I->scrollTo('body > section:nth-child(7) > div > div.tz-introduce-content.tz-introduce-content-style-4');
        $I->click('body > nav > header > div > div > div > ul > li:nth-child(1) > a');
        $I->waitForElement('h1');

    }

    /**
     * @param AcceptanceTester $I
     * @param startpage $startpage
     * @return array
     */
    protected function getItems(AcceptanceTester $I, startpage $startpage)
    {
        $items = $I->grabMultiple($startpage::$navMain, 'href');
        return $items;
    }
}
