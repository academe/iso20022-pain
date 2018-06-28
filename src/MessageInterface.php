<?php

namespace Consilience\Pain001;

/**
 * General interface for ISO-20022 messages
 */
interface MessageInterface
{
    /**
     * Returns a XML representation of the message
     *
     * @return string The XML source
     */
    public function asXml();
}
