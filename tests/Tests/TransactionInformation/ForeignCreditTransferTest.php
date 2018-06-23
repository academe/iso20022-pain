<?php

namespace Academe\Pain001\Tests\TransactionInformation;

use Academe\Pain001\Account\IBAN;
use Academe\Pain001\Money;
use Academe\Pain001\Address\StructuredPostalAddress;
use Academe\Pain001\Tests\TestCase;
use Academe\Pain001\TransactionInformation\ForeignCreditTransfer;

/**
 * @coversDefaultClass \Academe\Pain001\TransactionInformation\ForeignCreditTransfer
 */
class ForeignCreditTransferTest extends TestCase
{
    /**
     * @covers ::__construct
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidCreditorAgent()
    {
        $creditorAgent = $this->getMock(\Academe\Pain001\FinancialInstitutionInterface::class);

        $transfer = new ForeignCreditTransfer(
            'id000',
            'name',
            new Money\CHF(100),
            'name',
            new StructuredPostalAddress('foo', '99', '9999', 'bar'),
            new IBAN('CH31 8123 9000 0012 4568 9'),
            $creditorAgent
        );
    }
}
