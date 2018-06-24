<?php

namespace Academe\Pain001\Tests\PaymentInformation;

use DOMDocument;
use DOMXPath;
use Academe\Pain001\FinancialInstitution\BIC;
use Academe\Pain001\Account\IBAN;
use Money\Money;
use Academe\Pain001\PaymentInformation\CategoryPurposeCode;
use Academe\Pain001\PaymentInformation\PaymentInformation;
use Academe\Pain001\Account\PostalAccount;
use Academe\Pain001\Address\StructuredPostalAddress;
use Academe\Pain001\Tests\TestCase;
use Academe\Pain001\TransactionInformation\IS1CreditTransfer;

/**
 * @coversDefaultClass \Academe\Pain001\PaymentInformation\PaymentInformation
 */
class PaymentInformationTest extends TestCase
{
    /**
     * @covers ::__construct
     * @expectedException \InvalidArgumentException
     */
    public function testInvalidDebtorAgent()
    {
        $debtorAgent = $this->getMock(\Academe\Pain001\FinancialInstitutionInterface::class);

        $payment = new PaymentInformation(
            'id000',
            'name',
            $debtorAgent,
            new IBAN('CH31 8123 9000 0012 4568 9')
        );
    }

    /**
     * @covers ::hasPaymentTypeInformation
     */
    public function testHasPaymentTypeInformation()
    {
        $payment = new PaymentInformation(
            'id000',
            'name',
            new BIC('POFICHBEXXX'),
            new IBAN('CH31 8123 9000 0012 4568 9')
        );

        $this->assertFalse($payment->hasPaymentTypeInformation());
    }

    /**
     * @covers ::asDom
     */
    public function testInfersPaymentInformation()
    {
        $doc = new DOMDocument();
        $payment = new PaymentInformation(
            'id000',
            'name',
            new BIC('POFICHBEXXX'),
            new IBAN('CH31 8123 9000 0012 4568 9')
        );
        $payment->setCategoryPurpose(new CategoryPurposeCode('SALA'));
        $payment->addTransaction(new IS1CreditTransfer(
            'instr-001',
            'e2e-001',
            Money::CHF(10000), // CHF 100.00
            'Fritz Bischof',
            new StructuredPostalAddress('Dorfstrasse', '17', '9911', 'Musterwald'),
            new PostalAccount('60-9-9')
        ));
        $payment->addTransaction(new IS1CreditTransfer(
            'instr-002',
            'e2e-002',
            Money::CHF(30000), // CHF 300.00
            'Franziska Meier',
            new StructuredPostalAddress('Altstadt', '1a', '4998', 'Muserhausen'),
            new PostalAccount('80-151-4')
        ));

        $xml = $payment->asDom($doc);

        $xpath = new DOMXPath($doc);
        $this->assertNull($payment->getServiceLevel());
        $this->assertNull($payment->getLocalInstrument());
        $this->assertSame('CH02', $xpath->evaluate('string(./PmtTpInf/LclInstrm/Prtry)', $xml));
        $this->assertSame(0.0, $xpath->evaluate('count(./CdtTrfTxInf/PmtTpInf/LclInstrm/Prtry)', $xml));
    }
}
