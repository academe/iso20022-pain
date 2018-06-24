<?php

namespace Academe\Pain001\Tests\Money;

use Academe\Pain001\Money\Mixed;
use Money\Money;
use Academe\Pain001\Tests\TestCase;

class MixedTest extends TestCase
{
    /**
     * @covers \Academe\Pain001\Money\Mixed::plus
     */
    public function testPlus()
    {
        $sum = new Mixed(0);
        $sum = $sum->plus(Money::CHF(2456));
        $sum = $sum->plus(Money::CHF(1000));
        $sum = $sum->plus(Money::JPY(1200));

        $this->assertEquals('1234.56', $sum->format());
    }

    /**
     * @covers \Academe\Pain001\Money\Mixed::minus
     */
    public function testMinus()
    {
        $sum = new Mixed(100);
        $sum = $sum->minus(Money::CHF(5000));
        $sum = $sum->minus(Money::CHF(99));
        $sum = $sum->minus(Money::JPY(300));

        $this->assertEquals('-250.99', $sum->format());
    }
}
