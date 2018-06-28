<?php

namespace Consilience\Pain001\Account;

use DOMDocument;
use Consilience\Pain001\AccountInterface;

/**
 * UkBank
 */
class UkBank implements AccountInterface
{
    const MAX_LENGTH = 10;
    const PATTERN = '/^[0-9]{8,10}$/';

    /**
     * @var string
     */
    protected $accountNumber;

    /**
     * Constructor
     *
     * @param string $accountNumber
     *
     * @throws \InvalidArgumentException When the IBAN does contain invalid characters or the checksum calculation fails.
     */
    public function __construct($accountNumber)
    {
        $cleanedAccountNumber = str_replace(' ', '', strtoupper($accountNumber));

        if (!preg_match(self::PATTERN, $cleanedAccountNumber)) {
            throw new \InvalidArgumentException('UK bank account is not properly formatted.');
        }

        if (!self::check($cleanedAccountNumber)) {
            throw new \InvalidArgumentException('UK bank account has an invalid modulus check.');
        }

        $this->accountNumber = $cleanedAccountNumber;
    }

    /**
     * Format the IBAN either in a human-readable manner
     *
     * @return string The formatted IBAN
     */
    public function format()
    {
        return $this->accountNumber;
    }

    /**
     * Normalize the IBAN
     *
     * @return string The normalized IBAN
     */
    public function normalize()
    {
        return $this->accountNumber;
    }

    /**
     * Gets the country
     *
     * @return string A ISO 3166-1 alpha-2 country code
     */
    public function getCountry()
    {
        return 'GB';
    }

    /**
     * Checks whether the checksum of an IBAN is correct.
     * TODO: given the sort code, we should do a modulus check here.
     *
     * @param string $iban
     *
     * @return bool true if checksum is correct, false otherwise
     */
    protected static function check($iban)
    {
        return true;
    }

    /**
     * {@inheritdoc}
     */
    public function asDom(DOMDocument $doc)
    {
        $xml = $doc->createElement('Id');
        $other = $xml->appendChild($doc->createElement('Othr'));

        $other->appendChild($doc->createElement('Id', $this->normalize()));

        return $xml;
    }

    /**
     * Returns a string representation.
     *
     * @return string The string representation.
     */
    public function __toString()
    {
        return $this->format();
    }
}
