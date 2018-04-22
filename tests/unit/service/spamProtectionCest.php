<?php
namespace NCATesting\service;
use App\Service\SpamProtection;
use NCATesting\UnitTester;
use Codeception\Stub;

class spamProtectionCest
{
    private $fixture;

    public function _before(UnitTester $I)
    {
        $this->fixture = new SpamProtection();
    }

    // tests
    public function validateUserInputsReturnTrueOnValidData(UnitTester $I)
    {
        $this->fixture = Stub::make(
            $this->fixture,
            [
                'validateIp' => true
            ]
        );

        $data = [
            'ip' => ''
        ];

        $I->assertTrue($this->fixture->validateUserInputs($data));
    }
}
