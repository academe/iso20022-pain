<?php

namespace Consilience\Pain001\TransactionInformation;

use DOMDocument;
use InvalidArgumentException;
use Consilience\Pain001\Account\IBAN;
use Money\Money;
use Consilience\Pain001\PaymentInformation\PaymentInformation;
use Consilience\Pain001\Account\PostalAccount;
use Consilience\Pain001\PostalAddressInterface;
use Consilience\Pain001\Text;

/**
 * IS2CreditTransfer contains all the information about a IS 2-stage (type 2.2) transaction.
 */
class IS2CreditTransfer extends CreditTransfer
{
    /**
     * @var IBAN
     */
    protected $creditorIBAN;

    /**
     * @var string
     */
    protected $creditorAgentName;

    /**
     * @var PostalAccount
     */
    protected $creditorAgentPostal;

    /**
     * {@inheritdoc}
     *
     * @param IBAN          $creditorIBAN        IBAN of the creditor
     * @param string        $creditorAgentName   Name of the creditor's financial institution
     * @param \Consilience\Pain001\Account\PostalAccount $creditorAgentPostal Postal account of the creditor's financial institution
     *
     * @throws \InvalidArgumentException When the amount is not in EUR or CHF.
     */
    public function __construct(
        $instructionId,
        $endToEndId,
        Money $amount,
        $creditorName,
        PostalAddressInterface $creditorAddress,
        IBAN $creditorIBAN,
        $creditorAgentName,
        PostalAccount $creditorAgentPostal
    ) {
        /*if (!$amount instanceof Money\EUR && !$amount instanceof Money\CHF) {
            throw new InvalidArgumentException(sprintf(
                'The amount must be an instance of Consilience\Pain001\Money\EUR or Consilience\Pain001\Money\CHF (instance of %s given).',
                get_class($amount)
            ));
        }*/

        parent::__construct($instructionId, $endToEndId, $amount, $creditorName, $creditorAddress);

        $this->creditorIBAN = $creditorIBAN;
        $this->creditorAgentName = Text::assert($creditorAgentName, 70);
        $this->creditorAgentPostal = $creditorAgentPostal;
        $this->localInstrument = 'CH03';
    }

    /**
     * {@inheritdoc}
     */
    public function asDom(DOMDocument $doc, PaymentInformation $paymentInformation)
    {
        $root = $this->buildHeader($doc, $paymentInformation);

        $creditorAgent = $doc->createElement('CdtrAgt');
        $creditorAgentId = $doc->createElement('FinInstnId');
        $creditorAgentId->appendChild(Text::xml($doc, 'Nm', $this->creditorAgentName));
        $creditorAgentIdOther = $doc->createElement('Othr');
        $creditorAgentIdOther->appendChild($doc->createElement('Id', $this->creditorAgentPostal->format()));
        $creditorAgentId->appendChild($creditorAgentIdOther);
        $creditorAgent->appendChild($creditorAgentId);
        $root->appendChild($creditorAgent);

        $root->appendChild($this->buildCreditor($doc));

        $creditorAccount = $doc->createElement('CdtrAcct');
        $creditorAccount->appendChild($this->creditorIBAN->asDom($doc));
        $root->appendChild($creditorAccount);

        $this->appendPurpose($doc, $root);

        $this->appendRemittanceInformation($doc, $root);

        return $root;
    }
}
