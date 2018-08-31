<?php
namespace NCATesting;

use NCATesting\_generated\AcceptanceTesterActions;
use diversen\meta;

/**
 * Inherited Methods
 * @method void wantToTest($text)
 * @method void wantTo($text)
 * @method void execute($callable)
 * @method void expectTo($prediction)
 * @method void expect($prediction)
 * @method void amGoingTo($argumentation)
 * @method void am($role)
 * @method void lookForwardTo($achieveValue)
 * @method void comment($description)
 * @method \Codeception\Lib\Friend haveFriend($name, $actorClass = NULL)
 *
 * @SuppressWarnings(PHPMD)
*/
class AcceptanceTester extends \Codeception\Actor
{
    use AcceptanceTesterActions;

    /**
     * @param int $timeout
     */
    public function waitForAjax($timeout = 60)
    {
        $this->waitForJS(
            'return !!window.jQuery && window.jQuery.active == 0;',
            $timeout
        );
    }


    /**
     * @param int $timeout
     */
    public function waitForPageLoad($timeout = 60)
    {
        $this->waitForJS(
            'return document.readyState == "complete"',
            $timeout
        );
        $this->waitForAjax($timeout);
    }

    public function getMeta($tags = [], $timeout = 10) {
        $m = new meta();
        return $m->getMeta($this->getCurrentUrl());
    }

    public function getCurrentUrl()
    {
        return $this->executeJS("return location.href");
    }
}
