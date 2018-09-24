<?php
namespace NCATesting;
use NCATesting\AcceptanceTester;

class dhpgCest
{
    public function _before(AcceptanceTester $I)
    {
        $I->amOnUrl('https://www.dhpg.de/de/wir-beraten-sie-persoenlich/');
        $I->waitForElement('#header > div > form > button > i');
    }

    // tests
    public function checkSearchWithValidEnter(AcceptanceTester $I)
    {
        $search = 'firmen';
        $lupe = '#header > div > form > button > i';
        $I->click($lupe);
        $I->fillField('#searchbar-input', $search);
        $I->click($lupe);
        $I->waitForText('Suchergebnisse');
        $value = $I->grabValueFrom('#tx-indexedsearch-searchbox-sword');
        $I->assertSame($value, $search);


    }
}
