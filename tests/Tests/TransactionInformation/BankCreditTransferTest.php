<?php

namespace Academe\Pain001\Tests\TransactionInformation;

use Academe\Pain001\FinancialInstitution\BIC;
use Academe\Pain001\Account\IBAN;
use Money\Money;
use Academe\Pain001\Address\StructuredPostalAddress;
use Academe\Pain001\Tests\TestCase;
use Academe\Pain001\TransactionInformation\BankCreditTransfer;

/**
 * @coversDefaultClass \Academe\Pain001\TransactionInformation\BankCreditTransfer
 */
class BankCreditTransferTest extends TestCase
{
    /**
     * @covers ::__construct
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidCreditorAgent()
    {
        $creditorAgent = $this->getMock(\Academe\Pain001\FinancialInstitutionInterface::class);

        $transfer = new BankCreditTransfer(
            'id000',
            'name',
            Money::CHF(100),
            'name',
            new StructuredPostalAddress('foo', '99', '9999', 'bar'),
            new IBAN('CH31 8123 9000 0012 4568 9'),
            $creditorAgent
        );
    }

    /**
     * No longer limited to EUR and CHF
     * @covers ::__construct
     * @expectedException \InvalidArgumentException
     */
    /*
    public function testInvalidAmount()
    {
        $transfer = new BankCreditTransfer(
            'id000',
            'name',
            new Money\USD(100),
            'name',
            new StructuredPostalAddress('foo', '99', '9999', 'bar'),
            new IBAN('CH31 8123 9000 0012 4568 9'),
            new BIC('PSETPD2SZZZ')
        );
    }
    */
}
