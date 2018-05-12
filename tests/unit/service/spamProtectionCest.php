<?php
namespace NCATesting\service;
use App\Service\SpamProtection;
use Codeception\Example;
use NCATesting\UnitTester;
use Codeception\Stub;

class spamProtectionCest
{
    private $fixture;
    private $I;

    public function _before(UnitTester $I)
    {
        $this->I = $I;
        $this->fixture = new SpamProtection();
    }

    // tests
    public function validateUserInputsReturnTrueOnValidData(UnitTester $I)
    {
        $this->fixture = Stub::make(
            $this->fixture,
            [
                'validateName' => true,
                'validateEmail' => true,
                'validateMessage' => true,
                'validateIp' => true
            ]
        );

        $data = [
            'name' => '',
            'email' => '',
            'message' => '',
            'ip' => ''
        ];

        $I->assertTrue($this->fixture->validateUserInputs($data));
    }

    public function validateNameEmptyIsFalse(UnitTester $I)
    {
        $methodReturn = $this->getMethodReturn('validateName', '');
        $I->assertFalse($methodReturn);
    }

    public function validateNameIsSpam(UnitTester $I)
    {
        $methodReturn = $this->getMethodReturn('validateName', 'viagra');
        $I->assertFalse($methodReturn);
    }

    /**
     * @dataProvider invalidIpsProvider
     */
    public function validateIpWithInvalidIpsReturnFalse(UnitTester $I, Example $data)
    {
        $ip = $data[0];
        $methodReturn = $this->getMethodReturn('validateIp', $ip);
        $I->assertFalse($methodReturn, 'IP: ' . $ip);
    }
    /**
     * @return array
     */
    protected function invalidIpsProvider() // alternatively, if you want the function to be public, be sure to prefix it with `_`
    {
        return [
            [123],
            ['192.168.0.1']
        ];
    }

    /**
     * @dataProvider validIpsProvider
     */
    public function validateIpWithValidIpsReturnFalse(UnitTester $I, Example $data)
    {
        $this->fixture = Stub::make(
            $this->fixture,
            [
                'isIpFromDe' => true
            ]
        );

        $ip = $data[0];
        $methodReturn = $this->getMethodReturn('validateIp', $ip);
        $I->assertTrue($methodReturn, 'IP: ' . $ip);
    }

    /**
     * @return array
     */
    protected function validIpsProvider() // alternatively, if you want the function to be public, be sure to prefix it with `_`
    {
        return [
            ['176.95.142.6'] // DE
        ];
    }

    public function validateEmailEmptyStringReturnFalse(UnitTester $I)
    {
        $methodReturn = $this->getMethodReturn('validateEmail', '');
        $I->assertFalse($methodReturn);
    }

    public function validateEmailNotValidEmailReturnFalse(UnitTester $I)
    {
        $methodReturn = $this->getMethodReturn('validateEmail', 'testify');
        $I->assertFalse($methodReturn);
    }

    public function validateEmailValidEmailReturnTrue(UnitTester $I)
    {
        $methodReturn = $this->getMethodReturn('validateEmail', 'test@testify.com');
        $I->assertTrue($methodReturn);
    }

    public function validateMessageEmptyReturnFalse(UnitTester $I)
    {
        $methodReturn = $this->getMethodReturn('validateMessage', '');
        $I->assertFalse($methodReturn);
    }

    public function validateMessageSpamWordsReturnFalse(UnitTester $I)
    {
        $spamProtection = new SpamProtection();
        $spamWords = $spamProtection->spamWords;

        foreach ($spamWords as $spamWord) {
            $methodReturn = $this->getMethodReturn('validateMessage', $spamWord);
            $I->assertFalse($methodReturn, $spamWord);
        }
    }

    public function validateMessageWithLowerUpperMixSpamWords(UnitTester $I)
    {
        $spamWords = [
            'VIAGRA',
            'ViAgRa',
            'VIAgra'
        ];

        foreach ($spamWords as $spamWord) {
            $methodReturn = $this->getMethodReturn('validateMessage', $spamWord);
            $I->assertFalse($methodReturn, $spamWord);
        }
    }

    /**
     * @throws \ReflectionException
     */
    private function getMethodReturn($method, $param)
    {
        $class = new \ReflectionClass($this->fixture);
        $method = $class->getMethod($method);
        $method->setAccessible(true);
        $methodReturn = $method->invoke($this->fixture, $param);
        return $methodReturn;
    }



}
