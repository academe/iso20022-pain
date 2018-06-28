<?php

namespace Consilience\Pain001\PaymentInformation;

use Consilience\Pain001\FinancialInstitutionInterface;
use Consilience\Pain001\Account\IBAN;

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
