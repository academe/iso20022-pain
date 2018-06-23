<?php

namespace Academe\Pain001\Tests\PaymentInformation;

use DOMDocument;
use Academe\Pain001\PaymentInformation\CategoryPurposeCode;
use Academe\Pain001\Tests\TestCase;

/**
 * @coversDefaultClass \Academe\Pain001\PaymentInformation\CategoryPurposeCode
 */
class CategoryPurposeCodeTest extends TestCase
{
    /**
     * @dataProvider validSamples
     * @covers ::__construct
     */
    public function testValid($code)
    {
        $this->assertInstanceOf('Z38\SwissPayment\PaymentInformation\CategoryPurposeCode', new CategoryPurposeCode($code));
    }

    public function validSamples()
    {
        return [
            ['SALA'], // salary payment
            ['PENS'], // pension payment
        ];
    }

    /**
     * @dataProvider invalidSamples
     * @covers ::__construct
     * @expectedException \InvalidArgumentException
     */
    public function testInvalid($code)
    {
        new CategoryPurposeCode($code);
    }

    public function invalidSamples()
    {
        return [
            [''],
            ['sala'],
            ['SAL'],
            [' SALA'],
            ['B112'],
        ];
    }

    /**
     * @covers ::asDom
     */
    public function testAsDom()
    {
        $doc = new DOMDocument();
        $iid = new CategoryPurposeCode('SALA');

        $xml = $iid->asDom($doc);

        $this->assertSame('Cd', $xml->nodeName);
        $this->assertSame('SALA', $xml->textContent);
    }
}
