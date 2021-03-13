<?php

namespace Morrislaptop\SymfonyCustomNormalizers\Tests;

use PHPUnit\Framework\TestCase;
use Morrislaptop\SymfonyCustomNormalizers\ParsableDenormalizer;
use Morrislaptop\SymfonyCustomNormalizers\StringableNormalizer;
use Morrislaptop\SymfonyCustomNormalizers\StringableAndParsableNormalizer;
use Morrislaptop\SymfonyCustomNormalizers\NormalizeIfDenormalizableNormalizer;

class StringableAndParsableNormalizerTest extends TestCase
{
    /**
     * @var StringableAndParsableNormalizer
     */
    private $normalizer;

    protected function setUp(): void
    {
        $this->normalizer = new StringableAndParsableNormalizer();
    }

    public function testSupportNormalization()
    {
        $this->assertTrue($this->normalizer->supportsNormalization(new StringableAndParsableDummy('')));
        $this->assertFalse($this->normalizer->supportsNormalization(new JustStringableDummy()));
        $this->assertFalse($this->normalizer->supportsNormalization(new JustParsableDummy('')));
        $this->assertFalse($this->normalizer->supportsNormalization(new \stdClass()));
    }

    public function testSupportDenormalization()
    {
        $this->assertTrue($this->normalizer->supportsDenormalization('', StringableAndParsableDummy::class));
        $this->assertFalse($this->normalizer->supportsDenormalization('', JustStringableDummy::class));
        $this->assertTrue($this->normalizer->supportsDenormalization('', JustParsableDummy::class));
        $this->assertFalse($this->normalizer->supportsDenormalization('', \stdClass::class));
    }

    public function testNormalize()
    {
        $this->assertSame('hello worlds', $this->normalizer->normalize(new StringableAndParsableDummy('hello worlds')));
    }

    public function testDenormalize()
    {
        $actual = $this->normalizer->denormalize('hello worlds', StringableAndParsableDummy::class);

        $this->assertInstanceOf(StringableAndParsableDummy::class, $actual);
        $this->assertSame('hello worlds', $actual->str);
    }
}

class StringableAndParsableDummy implements \Stringable
{
    public $str;

    public function __construct($str)
    {
        $this->str = $str;
    }

    public function __toString(): string
    {
        return 'hello worlds';
    }

    public static function parse($str)
    {
        return new static($str);
    }
}

class JustStringableDummy implements \Stringable
{
    public function __toString(): string
    {
        return 'hello worlds';
    }
}

class JustParsableDummy
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
