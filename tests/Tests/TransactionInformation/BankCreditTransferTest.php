<?php

namespace Consilience\Pain001\Tests\TransactionInformation;

use Consilience\Pain001\FinancialInstitution\BIC;
use Consilience\Pain001\Account\IBAN;
use Money\Money;
use Consilience\Pain001\Address\StructuredPostalAddress;
use Consilience\Pain001\Tests\TestCase;
use Consilience\Pain001\TransactionInformation\BankCreditTransfer;

/**
 * @coversDefaultClass \Consilience\Pain001\TransactionInformation\BankCreditTransfer
 */
class BankCreditTransferTest extends TestCase
{
    /**
     * No longer invalid.
     * @covers ::__construct
     * @ expectedException \InvalidArgumentException
     */
    public function testInvalidCreditorAgent()
    {
        $creditorAgent = $this->getMock(\Consilience\Pain001\FinancialInstitutionInterface::class);

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
