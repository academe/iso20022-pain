<?php

namespace Consilience\Pain001;

/**
 * SupplementaryDataInterface
 */

use DOMElement;

interface SupplementaryDataInterface
{
    /**
     * Returns a XML representation of the supplementary data
     *
     * @param \DOMDocument $doc
     *
     * @return \DOMElement The built DOM element
     */
    public function asDom(\DOMDocument $doc) : DOMElement;
}
