<?php

namespace Academe\Pain001\TransactionInformation;

use DOMDocument;
use InvalidArgumentException;
use Academe\Pain001\FinancialInstitution\BIC;
use Academe\Pain001\FinancialInstitutionInterface;
use Academe\Pain001\Account\IBAN;
use Academe\Pain001\AccountInterface;
use Academe\Pain001\FinancialInstitution\IID;
use Academe\Pain001\PaymentInformation\PaymentInformation;
use Academe\Pain001\PostalAddressInterface;
use Money\Money;

/**
 * BankCreditTransfer contains all the information about a type 3 transaction.
 */
class BankCreditTransfer extends CreditTransfer
{
    /**
     * @var AccountInterface
     */
    protected $creditorIBAN;

    /**
     * @var \Academe\Pain001\FinancialInstitution\FinancialInstitutionInterface
     */
    protected $creditorAgent;

    /**
     * {@inheritdoc}
     *
     * @param AccountInterface    $creditorIBAN  IBAN of the creditor
     * @param BIC|IID $creditorAgent BIC or IID of the creditor's financial institution
     *
     * @throws \InvalidArgumentException When the amount is not in EUR or CHF or when the creditor agent is not BIC or IID.
     */
    public function __construct(
        $instructionId,
        $endToEndId,
        Money $amount,
        $creditorName,
        PostalAddressInterface $creditorAddress,
        AccountInterface $creditorIBAN,
        FinancialInstitutionInterface $creditorAgent
    ) {
        /*if (! $amount instanceof Money\EUR && !$amount instanceof Money\CHF) {
            throw new InvalidArgumentException(sprintf(
                'The amount must be an instance of Academe\Pain001\Money\EUR or Academe\Pain001\Money\CHF (instance of %s given).',
                get_class($amount)
            ));
        }*/

        // Also allows UkBank, and presumably other institutions.
        /*if (!$creditorAgent instanceof BIC && !$creditorAgent instanceof IID) {
            throw new InvalidArgumentException('The creditor agent must be an instance of BIC or IID.');
        }*/

        parent::__construct($instructionId, $endToEndId, $amount, $creditorName, $creditorAddress);

        $this->creditorIBAN = $creditorIBAN;
        $this->creditorAgent = $creditorAgent;
    }

    /**
     * {@inheritdoc}
     */
    public function asDom(DOMDocument $doc, PaymentInformation $paymentInformation)
    {
        $root = $this->buildHeader($doc, $paymentInformation);

        $creditorAgent = $doc->createElement('CdtrAgt');
        $creditorAgent->appendChild($this->creditorAgent->asDom($doc));
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
