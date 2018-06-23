<?php

namespace Academe\Pain001\Tests;

use InvalidArgumentException;
use Academe\Pain001\Account\GeneralAccount;

class GeneralAccountTest extends TestCase
{
    /**
     * @covers \Academe\Pain001\Account\GeneralAccount::__construct
     */
    public function testValid()
    {
        $instance = new GeneralAccount('A-123-4567890-78');
    }

    /**
     * @covers \Academe\Pain001\Account\GeneralAccount::__construct
     * @expectedException InvalidArgumentException
     */
    public function testInvalid()
    {
        $instance = new GeneralAccount('0123456789012345678901234567890123456789');
    }

    /**
     * @covers \Academe\Pain001\Account\GeneralAccount::format
     */
    public function testFormat()
    {
        $instance = new GeneralAccount('  123-4567890-78 AA ');
        $this->assertSame('  123-4567890-78 AA ', $instance->format());
    }
}
