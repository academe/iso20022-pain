<?php

namespace Consilience\Pain001\FinancialInstitution;

use DOMDocument;
use Consilience\Pain001\AccountInterface;
use Consilience\Pain001\FinancialInstitutionInterface;

/**
 * UkBank
 * FIXME: there will be a better name for this object, plus some
 * mapping of clearing system IDs to countries or banks, and validation
 * of sort codes. A complete "UK bank account" object could be used to
 * derive this, with all the validation built in.
 */
class UkBank implements FinancialInstitutionInterface
{
    const MAX_LENGTH = 10;
    const PATTERN = '/^[0-9]{6,6}$/';

    // FPS clearing
    const GB_CLAERING = 'GBDSC';

    /**
     * @var string
     */
    protected $sortCode;

    /**
     * Constructor
     *
     * @param string $sortCode
     *
     * @throws \InvalidArgumentException When the IBAN does contain invalid characters or the checksum calculation fails.
     */
    public function __construct($sortCode)
    {
        $cleanedAccountNumber = str_replace(' ', '', strtoupper($sortCode));

        if (!preg_match(self::PATTERN, $cleanedAccountNumber)) {
            throw new \InvalidArgumentException('UK bank account sort code is not properly formatted.');
        }

        if (!self::check($cleanedAccountNumber)) {
            throw new \InvalidArgumentException('UK bank account sort code has an invalid modulus check.');
        }

        $this->sortCode = $cleanedAccountNumber;
    }

    /**
     * Format the IBAN either in a human-readable manner
     *
     * @return string The formatted IBAN
     */
    public function format()
    {
        return $this->sortCode;
    }

    /**
     * Normalize the IBAN
     *
     * @return string The normalized IBAN
     */
    public function normalize()
    {
        return $this->sortCode;
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
        $xml = $doc->createElement('FinInstnId');
        $ClrSysMmbId = $xml->appendChild($doc->createElement('ClrSysMmbId'));
        $ClrSysId = $ClrSysMmbId->appendChild($doc->createElement('ClrSysId'));
        $ClrSysId->appendChild($doc->createElement('Cd', static::GB_CLAERING));
        $ClrSysMmbId->appendChild($doc->createElement('MmbId', $this->format()));

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
