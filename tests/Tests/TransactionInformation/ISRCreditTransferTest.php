<?php

namespace Consilience\Pain001\Tests\TransactionInformation;

use Consilience\Pain001\Account\ISRParticipant;
use Money\Money;
use Consilience\Pain001\Address\StructuredPostalAddress;
use Consilience\Pain001\Tests\TestCase;
use Consilience\Pain001\TransactionInformation\ISRCreditTransfer;

/**
 * @coversDefaultClass \Consilience\Pain001\TransactionInformation\ISRCreditTransfer
 */
class ISRCreditTransferTest extends TestCase
{
    /**
     * @covers ::__construct
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidAmount()
    {
        $transfer = new ISRCreditTransfer(
            'id000',
            'name',
            Money::USD(100),
            new ISRParticipant('10-2424-4'),
            '120000000000234478943216899'
        );
    }

    /**
     * @covers ::__construct
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidCreditorReference()
    {
        $transfer = new ISRCreditTransfer(
            'id000',
            'name',
            Money::CHF(100),
            new ISRParticipant('01-25083-7'),
            '120000000000234478943216891'
        );
    }

    /**
     * @covers ::setRemittanceInformation
     * @expectedException \LogicException
     */
    public function testSetRemittanceInformation()
    {
        $transfer = new ISRCreditTransfer(
            'id000',
            'name',
            Money::CHF(100),
            new ISRParticipant('01-25083-7'),
            '120000000000234478943216899'
        );

        $transfer->setRemittanceInformation('not allowed');
    }

    /**
     * @covers ::setCreditorDetails
     */
    public function testCreditorDetails()
    {
        $transfer = new ISRCreditTransfer(
            'id000',
            'name',
            Money::CHF(100),
            new ISRParticipant('01-25083-7'),
            '120000000000234478943216899'
        );

        $creditorName = 'name';
        $creditorAddress = new StructuredPostalAddress('foo', '99', '9999', 'bar');
        $transfer->setCreditorDetails($creditorName, $creditorAddress);
    }
}
