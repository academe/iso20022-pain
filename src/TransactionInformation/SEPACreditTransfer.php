<?php

namespace Consilience\Pain001\TransactionInformation;

use DOMDocument;
use Consilience\Pain001\FinancialInstitution\BIC;
use Consilience\Pain001\Account\IBAN;
use Money\Money;
use Consilience\Pain001\PaymentInformation\PaymentInformation;
use Consilience\Pain001\PostalAddressInterface;

/**
 * SEPACreditTransfer contains all the information about a foreign SEPA (type 5) transaction.
 */
class SEPACreditTransfer extends CreditTransfer
{
    /**
     * @var IBAN
     */
    protected $creditorIBAN;

    /**
     * @var BIC|null
     */
    protected $creditorAgentBIC;

    /**
     * {@inheritdoc}
     *
     * @param IBAN     $creditorIBAN     IBAN of the creditor
     * @param BIC|null $creditorAgentBIC BIC of the creditor's financial institution
     */
    public function __construct(
        $instructionId,
        $endToEndId,
        Money $amount, // Must be EUR (TODO: validate)
        $creditorName,
        PostalAddressInterface $creditorAddress,
        IBAN $creditorIBAN,
        BIC $creditorAgentBIC = null
    ) {
        parent::__construct($instructionId, $endToEndId, $amount, $creditorName, $creditorAddress);

        $this->creditorIBAN = $creditorIBAN;
        $this->serviceLevel = 'SEPA';

        if ($creditorAgentBIC !== null) {
            @trigger_error('Setting the creditor agent BIC of SEPA payments is deprecated. The execution of the payment will be based on the IBAN.', E_USER_DEPRECATED);
            $this->creditorAgentBIC = $creditorAgentBIC;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function asDom(DOMDocument $doc, PaymentInformation $paymentInformation)
    {
        $root = $this->buildHeader($doc, $paymentInformation);

        $root->appendChild($doc->createElement('ChrgBr', 'SLEV'));

        if ($this->creditorAgentBIC !== null) {
            $creditorAgent = $doc->createElement('CdtrAgt');
            $creditorAgent->appendChild($this->creditorAgentBIC->asDom($doc));
            $root->appendChild($creditorAgent);
        }

        $root->appendChild($this->buildCreditor($doc));

        $creditorAccount = $doc->createElement('CdtrAcct');
        $creditorAccount->appendChild($this->creditorIBAN->asDom($doc));
        $root->appendChild($creditorAccount);

        $this->appendPurpose($doc, $root);

        $this->appendRemittanceInformation($doc, $root);

        return $root;
    }
}
