<?php

namespace Consilience\Pain001\Tests\FinancialInstitution;

use Consilience\Pain001\FinancialInstitution\BIC;
use Consilience\Pain001\Tests\TestCase;

class BICTest extends TestCase
{
    /**
     * @dataProvider validSamples
     * @covers \Consilience\Pain001\FinancialInstitution\BIC::__construct
     */
    public function testValid($bic)
    {
        $this->check($bic, true);
    }

    /**
     * @covers \Consilience\Pain001\FinancialInstitution\BIC::__construct
     */
    public function testInvalidLength()
    {
        $this->check('AABAFI22F', false);
        $this->check('HANDFIHH00', false);
    }

    /**
     * @covers \Consilience\Pain001\FinancialInstitution\BIC::__construct
     */
    public function testInvalidChars()
    {
        $this->check('HAND-FIHH', false);
        $this->check('HAND FIHH', false);
    }

    /**
     * @dataProvider validSamples
     * @covers \Consilience\Pain001\FinancialInstitution\BIC::format
     */
    public function testFormat($bic)
    {
        $instance = new BIC($bic);
        $this->assertEquals($bic, $instance->format());
    }

    public function validSamples()
    {
        return [
            ['AABAFI22'],
            ['HANDFIHH'],
            ['DEUTDEFF500'],
        ];
    }

    protected function check($iban, $valid)
    {
        $exception = false;
        try {
            $temp = new BIC($iban);
        } catch (\InvalidArgumentException $e) {
            $exception = true;
        }
        $this->assertTrue($exception != $valid);
    }
}
