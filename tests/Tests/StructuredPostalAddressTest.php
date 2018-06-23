<?php

namespace Academe\Pain001\Tests;

use Academe\Pain001\Address\StructuredPostalAddress;

/**
 * @coversDefaultClass \Academe\Pain001\Address\StructuredPostalAddress
 */
class StructuredPostalAddressTest extends TestCase
{
    /**
     * @covers ::sanitize
     */
    public function testSanitize()
    {
        $this->assertInstanceOf(\Academe\Pain001\Address\StructuredPostalAddress::class, StructuredPostalAddress::sanitize(
            'Dorfstrasse',
            '∅',
            'Pfaffenschlag bei Waidhofen an der Thaya',
            '3834',
            'AT'
        ));
    }
}
