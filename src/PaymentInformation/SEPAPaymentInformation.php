<?php

namespace Academe\Pain001\PaymentInformation;

use Academe\Pain001\FinancialInstitutionInterface;
use Academe\Pain001\Account\IBAN;

/**
 * SEPAPaymentInformation contains a group of SEPA transactions
 */
class SEPAPaymentInformation extends PaymentInformation
{
    /**
     * {@inheritdoc}
     */
    public function __construct($id, $debtorName, FinancialInstitutionInterface $debtorAgent, IBAN $debtorIBAN)
    {
        parent::__construct($id, $debtorName, $debtorAgent, $debtorIBAN);
        $this->serviceLevel = 'SEPA';
    }
}
