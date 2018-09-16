<?php
namespace NCATesting\page;
use NCATesting\AcceptanceTester;
use NCATesting\Helper\Config;

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

    public function hasDescription(AcceptanceTester $I)
    {
        $meta = $I->getMeta(['description']);
        $I->assertNotEmpty($meta['description']);
    }

    public function imagesHasAlt(AcceptanceTester $I)
    {
        $altImages = $I->grabMultiple('img', 'alt');
        $srcImages = $I->grabMultiple('img', 'src');

        foreach ($altImages as $key => $altImage) {
            $I->assertNotEmpty($altImage, $srcImages[$key]);
        }
    }

    public function validateInternalAndExternalLinkTargets(AcceptanceTester $I, Config $helperConfig)
    {
        return;
        $specialLinks = [
            'tel:+',
            '//symfony.com',
            'https://clea'
        ];

        $url = $helperConfig->getUrlFromConfigWebdriver('url');

        $items = $I->grabMultiple('a', 'href');
        $itemsTargets = $I->grabMultiple('a', 'target');
        $itemsRel = $I->grabMultiple('a', 'Rel');

        foreach ($items as $key => $item) {
            if($item === null) {
                continue;
            }

            if(strpos($item, $url) === false) {
                foreach ($specialLinks as $specialLink) {
                    if(strpos($item, $specialLink) !== false) {
                        $I->assertSame('', $itemsTargets[$key], 'Item no blank: ' . $item);
                        continue 2;
                    }
                }

                $I->assertSame('noopener', $itemsRel[$key], 'Item rel is noopener ' . $item . $key);
                $I->assertSame('_blank', $itemsTargets[$key], 'Item blank: ' . $item . $key);
            } else {
                $I->assertSame('', $itemsTargets[$key], 'Item no blank: ' . $item);
            }
        }
    }

}
