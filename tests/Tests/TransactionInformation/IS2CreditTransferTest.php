<?php

namespace Academe\Pain001\Tests\TransactionInformation;

use Academe\Pain001\Account\IBAN;
use Academe\Pain001\Money;
use Academe\Pain001\Account\PostalAccount;
use Academe\Pain001\Address\StructuredPostalAddress;
use Academe\Pain001\Tests\TestCase;
use Academe\Pain001\TransactionInformation\IS2CreditTransfer;

/**
 * @coversDefaultClass \Academe\Pain001\TransactionInformation\IS2CreditTransfer
 */
class IS2CreditTransferTest extends TestCase
{
    /**
     * @covers ::__construct
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidAmount()
    {
        $transfer = new IS2CreditTransfer(
            'id000',
            'name',
            new Money\USD(100),
            'creditor name',
            new StructuredPostalAddress('foo', '99', '9999', 'bar'),
            new Iban('AZ21 NABZ 0000 0000 1370 1000 1944'),
            'name',
            new PostalAccount('10-2424-4')
        );
    }
}
