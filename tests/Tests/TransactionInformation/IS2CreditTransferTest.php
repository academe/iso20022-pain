<?php

namespace Consilience\Pain001\Tests\TransactionInformation;

use Consilience\Pain001\Account\IBAN;
use Money\Money;
use Consilience\Pain001\Account\PostalAccount;
use Consilience\Pain001\Address\StructuredPostalAddress;
use Consilience\Pain001\Tests\TestCase;
use Consilience\Pain001\TransactionInformation\IS2CreditTransfer;

/**
 * @coversDefaultClass \Consilience\Pain001\TransactionInformation\IS2CreditTransfer
 */
class IS2CreditTransferTest extends TestCase
{
    /**
     * @covers ::__construct
     * @ expectedException \InvalidArgumentException
     */
    public function testInvalidAmount()
    {
        $transfer = new IS2CreditTransfer(
            'id000',
            'name',
            Money::USD(100),
            'creditor name',
            new StructuredPostalAddress('foo', '99', '9999', 'bar'),
            new Iban('AZ21 NABZ 0000 0000 1370 1000 1944'),
            'name',
            new PostalAccount('10-2424-4')
        );
    }
}
