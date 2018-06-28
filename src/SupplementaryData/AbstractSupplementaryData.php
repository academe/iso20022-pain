<?php

namespace Consilience\Pain001\SupplementaryData;

/**
 * AbstractSupplementaryData
 */

use Consilience\Pain001\SupplementaryDataInterface;
use DOMDocument;
use DOMElement;

abstract class AbstractSupplementaryData implements SupplementaryDataInterface
{
    /**
     * string
     */
    protected $plcAndNm;

    public function asDom(DOMDocument $doc) : DOMElement
    {
        // The root of this object.
        $splmtryData = $doc->appendChild($doc->createElement('SplmtryData'));

        // Optional PlcAndNm

        if ($this->getPlcAndNm() !== null) {
            $splmtryData->appendChild($doc->createElement('PlcAndNm', $this->getPlcAndNm()));
        }

        // Mandatory Envlp

        $envelope = $splmtryData->appendChild($doc->createElement('Envlp'));

        $envelope->appendChild($this->buildEnvelope($doc));

        return $splmtryData;
    }

    public function getPlcAndNm()
    {
        return $this->plcAndNm;
    }

    /**
     * Build the supplementary data envelope content.
     */
    abstract public function buildEnvelope(DOMDocument $doc);
}
