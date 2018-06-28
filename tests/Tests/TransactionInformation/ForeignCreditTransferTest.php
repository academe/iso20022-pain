<?php

namespace Consilience\Pain001\Tests\TransactionInformation;

use Consilience\Pain001\Account\IBAN;
use Money\Money;
use Consilience\Pain001\Address\StructuredPostalAddress;
use Consilience\Pain001\Tests\TestCase;
use Consilience\Pain001\TransactionInformation\ForeignCreditTransfer;

/**
 * @coversDefaultClass \Consilience\Pain001\TransactionInformation\ForeignCreditTransfer
 */
class ForeignCreditTransferTest extends TestCase
{
    /**
     * @covers ::__construct
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidCreditorAgent()
    {
        $creditorAgent = $this->getMock(\Consilience\Pain001\FinancialInstitutionInterface::class);

        $transfer = new ForeignCreditTransfer(
            'id000',
            'name',
            Money::CHF(100),
            'name',
            new StructuredPostalAddress('foo', '99', '9999', 'bar'),
            new IBAN('CH31 8123 9000 0012 4568 9'),
            $creditorAgent
        );
    }
}
