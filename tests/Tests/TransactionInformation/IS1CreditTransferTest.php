<?php

namespace Consilience\Pain001\Tests\TransactionInformation;

use Money\Money;
use Consilience\Pain001\Account\PostalAccount;
use Consilience\Pain001\Address\StructuredPostalAddress;
use Consilience\Pain001\Tests\TestCase;
use Consilience\Pain001\TransactionInformation\IS1CreditTransfer;

/**
 * @coversDefaultClass \Consilience\Pain001\TransactionInformation\IS1CreditTransfer
 */
class IS1CreditTransferTest extends TestCase
{
    /**
     * @covers ::__construct
     * @ expectedException \InvalidArgumentException
     */
    public function testInvalidAmount()
    {
        $transfer = new IS1CreditTransfer(
            'id000',
            'name',
            Money::USD(100),
            'name',
            new StructuredPostalAddress('foo', '99', '9999', 'bar'),
            new PostalAccount('10-2424-4')
        );
    }
}
