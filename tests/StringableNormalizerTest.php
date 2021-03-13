<?php

namespace Morrislaptop\SymfonyCustomNormalizers\Tests;

use Morrislaptop\SymfonyCustomNormalizers\StringableNormalizer;
use PHPUnit\Framework\TestCase;

class StringableNormalizerTest extends TestCase
{
    /**
     * @var StringableNormalizer
     */
    private $normalizer;

    protected function setUp(): void
    {
        $this->normalizer = new StringableNormalizer();
    }

    public function testSupportNormalization()
    {
        $this->assertTrue($this->normalizer->supportsNormalization(new StringableDummy()));
        $this->assertTrue($this->normalizer->supportsNormalization(new StringableLegacyDummy()));
        $this->assertFalse($this->normalizer->supportsNormalization(new \stdClass()));
    }

    public function testNormalize()
    {
        $this->assertSame('hello worlds', $this->normalizer->normalize(new StringableDummy()));
    }

    public function testNormalizeLegacy()
    {
        $this->assertSame('hello worlds', $this->normalizer->normalize(new StringableLegacyDummy()));
    }
}

class StringableDummy implements \Stringable
{
    public function __toString(): string
    {
        return 'hello worlds';
    }
}

class StringableLegacyDummy
{
    public function __toString(): string
    {
        return 'hello worlds';
    }
}
