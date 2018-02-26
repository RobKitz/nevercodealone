<?php
namespace NCATesting;
use NCATesting\AcceptanceTester;

class securityCest
{
    public function adminRedirectLogin(AcceptanceTester $I)
    {
        $I->amOnPage('/admin');
        $I->canSeeInCurrentUrl('login');
    }

    public function openCommunityRoutes(AcceptanceTester $I)
    {
        $routes = [
            'login',
            'register',
            'thankyou'
        ];

        foreach ($routes as $route) {
            $path = '/community/' . $route;
            $I->amOnPage($path);
            $I->canSeeInCurrentUrl($path);
        }
    }
}
