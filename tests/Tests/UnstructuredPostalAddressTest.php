<?php

namespace Academe\Pain001\Tests;

use Academe\Pain001\Address\UnstructuredPostalAddress;

/**
 * @coversDefaultClass \Academe\Pain001\Address\UnstructuredPostalAddress
 */
class UnstructuredPostalAddressTest extends TestCase
{
    /**
     * @covers ::sanitize
     */
    public function testSanitize()
    {
        $this->assertInstanceOf(\Academe\Pain001\Address\UnstructuredPostalAddress::class, UnstructuredPostalAddress::sanitize(
            "Dorf—Strasse 3\n\n",
            "8000\tZürich"
        ));
    }
}
