<?php

namespace Morrislaptop\SymfonyCustomNormalizers\Tests;

use Morrislaptop\SymfonyCustomNormalizers\ParsableDenormalizer;
use PHPUnit\Framework\TestCase;

class ParsableDenormalizerTest extends TestCase
{
    /**
     * @var ParsableDenormalizer
     */
    private $normalizer;

    protected function setUp(): void
    {
        $this->normalizer = new ParsableDenormalizer();
    }

    public function testSupportDenormalization()
    {
        $this->assertTrue($this->normalizer->supportsDenormalization('', ParsableDummy::class));
        $this->assertFalse($this->normalizer->supportsDenormalization('', \stdClass::class));
    }

    public function testDenormalize()
    {
        $actual = $this->normalizer->denormalize('hello worlds', ParsableDummy::class);

        $this->assertInstanceOf(ParsableDummy::class, $actual);
        $this->assertSame('hello worlds', $actual->str);
    }
}

class ParsableDummy
{
    public $str;

    public function __construct($str)
    {
        $this->str = $str;
    }

    public static function parse($str)
    {
        return new static($str);
    }
}
