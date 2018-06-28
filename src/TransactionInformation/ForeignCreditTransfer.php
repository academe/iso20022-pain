<?php

namespace Consilience\Pain001\TransactionInformation;

use DOMDocument;
use Consilience\Pain001\AccountInterface;
use Consilience\Pain001\FinancialInstitution\BIC;
use Consilience\Pain001\FinancialInstitutionAddress;
use Consilience\Pain001\FinancialInstitutionInterface;
use Money\Money;
use Consilience\Pain001\PaymentInformation\PaymentInformation;
use Consilience\Pain001\PostalAddressInterface;

/**
 * ForeignCreditTransfer contains all the information about a foreign (type 6) transaction.
 */
class ForeignCreditTransfer extends CreditTransfer
{
    /**
     * @var \Consilience\Pain001\AccountInterface\AccountInterface
     */
    protected $creditorAccount;

    /**
     * @var BIC|FinancialInstitutionAddress
     */
    protected $creditorAgent;

    /**
     * @var BIC
     */
    protected $intermediaryAgent;

    /**
     * {@inheritdoc}
     *
     * @param \Consilience\Pain001\AccountInterface\AccountInterface                $creditorAccount Account of the creditor
     * @param BIC|FinancialInstitutionAddress $creditorAgent   BIC or address of the creditor's financial institution
     */
    public function __construct(
        $instructionId,
        $endToEndId,
        Money $amount,
        $creditorName,
        PostalAddressInterface $creditorAddress,
        AccountInterface $creditorAccount,
        FinancialInstitutionInterface $creditorAgent
    ) {
        parent::__construct($instructionId, $endToEndId, $amount, $creditorName, $creditorAddress);

        if (!$creditorAgent instanceof BIC && !$creditorAgent instanceof FinancialInstitutionAddress) {
            throw new \InvalidArgumentException('The creditor agent must be an instance of BIC or FinancialInstitutionAddress.');
        }

        $this->creditorAccount = $creditorAccount;
        $this->creditorAgent = $creditorAgent;
    }

    /**
     * Set the intermediary agent of the transaction.
     *
     * @param BIC $intermediaryAgent BIC of the intmediary agent
     */
    public function setIntermediaryAgent(BIC $intermediaryAgent)
    {
        $this->intermediaryAgent = $intermediaryAgent;
    }

    /**
     * {@inheritdoc}
     */
    public function asDom(DOMDocument $doc, PaymentInformation $paymentInformation)
    {
        $root = $this->buildHeader($doc, $paymentInformation);

        if ($this->intermediaryAgent !== null) {
            $intermediaryAgent = $doc->createElement('IntrmyAgt1');
            $intermediaryAgent->appendChild($this->intermediaryAgent->asDom($doc));
            $root->appendChild($intermediaryAgent);
        }

        $creditorAgent = $doc->createElement('CdtrAgt');
        $creditorAgent->appendChild($this->creditorAgent->asDom($doc));
        $root->appendChild($creditorAgent);

        $root->appendChild($this->buildCreditor($doc));

        $creditorAccount = $doc->createElement('CdtrAcct');
        $creditorAccount->appendChild($this->creditorAccount->asDom($doc));
        $root->appendChild($creditorAccount);

        $this->appendPurpose($doc, $root);

        $this->appendRemittanceInformation($doc, $root);

        return $root;
    }
}
