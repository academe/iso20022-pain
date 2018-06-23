<?php

namespace Academe\Pain001\Tests\TransactionInformation;

use DOMDocument;
use Academe\Pain001\Tests\TestCase;
use Academe\Pain001\TransactionInformation\PurposeCode;

/**
 * @coversDefaultClass \Academe\Pain001\TransactionInformation\PurposeCode
 */
class PurposeCodeTest extends TestCase
{
    /**
     * @dataProvider validSamples
     * @covers ::__construct
     */
    public function testValid($code)
    {
        $this->assertInstanceOf(\Academe\Pain001\TransactionInformation\PurposeCode::class, new PurposeCode($code));
    }

    public function validSamples()
    {
        return [
            ['SALA'], // salary payment
            ['PENS'], // pension payment
            ['DNTS'], // dental services
            ['B112'], // US mutual fund trailer fee (12b-1) payment
        ];
    }

    /**
     * @dataProvider invalidSamples
     * @covers ::__construct
     * @expectedException \InvalidArgumentException
     */
    public function testInvalid($code)
    {
        new PurposeCode($code);
    }

    public function invalidSamples()
    {
        return [
            [''],
            ['sala'],
            ['SAL'],
            [' SALA'],
        ];
    }

    /**
     * @covers ::asDom
     */
    public function testAsDom()
    {
        $doc = new DOMDocument();
        $iid = new PurposeCode('PHON');

        $xml = $iid->asDom($doc);

        $this->assertSame('Cd', $xml->nodeName);
        $this->assertSame('PHON', $xml->textContent);
    }
}
