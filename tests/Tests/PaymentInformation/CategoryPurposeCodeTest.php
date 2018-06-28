<?php

namespace Consilience\Pain001\Tests\PaymentInformation;

use DOMDocument;
use Consilience\Pain001\PaymentInformation\CategoryPurposeCode;
use Consilience\Pain001\Tests\TestCase;

/**
 * @coversDefaultClass \Consilience\Pain001\PaymentInformation\CategoryPurposeCode
 */
class CategoryPurposeCodeTest extends TestCase
{
    /**
     * @dataProvider validSamples
     * @covers ::__construct
     */
    public function testValid($code)
    {
        $this->assertInstanceOf(\Consilience\Pain001\PaymentInformation\CategoryPurposeCode::class, new CategoryPurposeCode($code));
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
