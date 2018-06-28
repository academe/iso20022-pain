<?php

namespace Consilience\Pain001\Tests\PaymentInformation;

use Consilience\Pain001\FinancialInstitution\BIC;
use Consilience\Pain001\Account\IBAN;
use Money\Money;
use Consilience\Pain001\PaymentInformation\SEPAPaymentInformation;
use Consilience\Pain001\Address\StructuredPostalAddress;
use Consilience\Pain001\Tests\TestCase;
use Consilience\Pain001\TransactionInformation\BankCreditTransfer;
use Consilience\Pain001\TransactionInformation\SEPACreditTransfer;
use Consilience\Pain001\Address\UnstructuredPostalAddress;

/**
 * @coversDefaultClass \Consilience\Pain001\PaymentInformation\SEPAPaymentInformation
 */
class SEPAPaymentInformationTest extends TestCase
{
    /**
     * @covers ::hasPaymentTypeInformation
     */
    public function testHasPaymentTypeInformation()
    {
        $payment = new SEPAPaymentInformation(
            'id000',
            'name',
            new BIC('POFICHBEXXX'),
            new IBAN('CH31 8123 9000 0012 4568 9')
        );

        $this->assertTrue($payment->hasPaymentTypeInformation());
    }

    /**
     * @covers ::asDom
     */
    public function testAsDomWithSEPATransaction()
    {
        $payment = new SEPAPaymentInformation(
            'id000',
            'name',
            new BIC('POFICHBEXXX'),
            new IBAN('CH31 8123 9000 0012 4568 9')
        );
        $payment->addTransaction(new SEPACreditTransfer(
            'instr-001',
            'e2e-001',
            Money::EUR(70000), // EUR 700.00
            'Muster Immo AG',
            new UnstructuredPostalAddress('Musterstraße 35', '80333 München', 'DE'),
            new IBAN('DE89 3704 0044 0532 0130 00'),
            new BIC('COBADEFFXXX')
        ));

        $doc = new \DOMDocument();
        $dom = $payment->asDom($doc);
        $doc->appendChild($dom);

        $xpath = new \DOMXPath($doc);
        $this->assertEquals('SEPA', $xpath->evaluate('string(/PmtInf/PmtTpInf/SvcLvl/Cd)'));
        $this->assertEquals(0, $xpath->evaluate('count(//CdtTrfTxInf/PmtTpInf)'));
    }

    /**
     * @covers ::asDom
     * @expectedException \LogicException
     * @expectedExceptionMessage You can not set the service level on B- and C-level.
     */
    public function testAsDomWithNonSEPATransaction()
    {
        $payment = new SEPAPaymentInformation(
            'id000',
            'name',
            new BIC('POFICHBEXXX'),
            new IBAN('CH31 8123 9000 0012 4568 9')
        );
        $payment->addTransaction(new BankCreditTransfer(
            'instr-001',
            'e2e-001',
            Money::CHF(130000), // CHF 1300.00
            'Muster Transport AG',
            new StructuredPostalAddress('Wiesenweg', '14b', '8058', 'Zürich-Flughafen'),
            new IBAN('CH51 0022 5225 9529 1301 C'),
            new BIC('UBSWCHZH80A')
        ));

        $doc = new \DOMDocument();
        $payment->asDom($doc);
    }
}
