<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Symfony\Component\Serializer\Tests\Normalizer;

use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\SerializerInterface;
use Morrislaptop\SymfonyCustomNormalizers\StringableNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * @author Craig Morris <craig.michael.morris@gmail.com>
 */
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
