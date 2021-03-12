<?php

namespace Morrislaptop\SymfonyCustomNormalizers\Tests;

use Brick\DateTime\LocalDate;
use Carbon\Carbon;
use DateTimeImmutable;
use Morrislaptop\SymfonyCustomNormalizers\CarbonNormalizer;
use Morrislaptop\SymfonyCustomNormalizers\LocalDateNormalizer;
use Morrislaptop\SymfonyCustomNormalizers\ParsableDenormalizer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\JsonSerializableNormalizer;
use Symfony\Component\Serializer\Serializer;

class ParsableDenormalizerTest extends TestCase
{
    /** @test */
    public function it_can_normalize_a_local_date_instance()
    {
        // Arrange.
        $denormalized = LocalDate::of(2021, 03, 11);
        $serializer = new Serializer([
            // new LocalDateNormalizer,
            new JsonSerializableNormalizer
        ]);

        // Act.
        $normalized = $serializer->normalize($denormalized);

        // Assert.
        $this->assertEquals('2021-03-11', $normalized);
    }

    /** @test */
    public function it_can_denormalize_an_object_with_a_parse_method()
    {
        // Arrange.
        $normalized = '2021-03-11';
        $serializer = new Serializer([new ParsableDenormalizer]);

        // Act.
        $denormalized = $serializer->denormalize($normalized, LocalDate::class);

        // Assert.
        $this->assertInstanceOf(LocalDate::class, $denormalized);
        $this->assertEquals(2021, $denormalized->getYear());
        $this->assertEquals(03, $denormalized->getMonth());
        $this->assertEquals(11, $denormalized->getDay());
    }
}
