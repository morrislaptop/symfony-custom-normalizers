<?php

namespace Morrislaptop\SymfonyCustomNormalizers\Tests;

use Carbon\Carbon;
use DateTimeImmutable;
use Morrislaptop\SymfonyCustomNormalizers\CarbonNormalizer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Serializer;

class CarbonNormalizerTest extends TestCase
{
    /** @test */
    public function it_can_normalize_a_carbon_instance()
    {
        // Arrange.
        $denormalized = new Carbon('1 Jan 2021');
        $serializer = new Serializer([new CarbonNormalizer]);

        // Act.
        $normalized = $serializer->normalize($denormalized);

        // Assert.
        $this->assertEquals('2021-01-01T00:00:00+00:00', $normalized);
    }

    /** @test */
    public function it_can_denormalize_a_carbon_instance()
    {
        // Arrange.
        $normalized = '2021-01-01T00:00:00+00:00';
        $serializer = new Serializer([new CarbonNormalizer]);

        // Act.
        $denormalized = $serializer->denormalize($normalized, Carbon::class);

        // Assert.
        $this->assertInstanceOf(Carbon::class, $denormalized);
        $this->assertEquals('2021-01-01 00:00:00', $denormalized->toDateTimeString());
    }
}
