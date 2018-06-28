<?php

namespace Consilience\Pain001\Tests\Account;

use Consilience\Pain001\Tests\TestCase;
use InvalidArgumentException;
use Consilience\Pain001\Account\GeneralAccount;

class GeneralAccountTest extends TestCase
{
    /**
     * @covers \Consilience\Pain001\Account\GeneralAccount::__construct
     */
    public function testValid()
    {
        $instance = new GeneralAccount('A-123-4567890-78');
    }

    /**
     * @covers \Consilience\Pain001\Account\GeneralAccount::__construct
     * @expectedException InvalidArgumentException
     */
    public function testInvalid()
    {
        $instance = new GeneralAccount('0123456789012345678901234567890123456789');
    }

    /**
     * @covers \Consilience\Pain001\Account\GeneralAccount::format
     */
    public function testFormat()
    {
        $instance = new GeneralAccount('  123-4567890-78 AA ');
        $this->assertSame('  123-4567890-78 AA ', $instance->format());
    }
}
