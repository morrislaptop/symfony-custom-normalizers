<?php

namespace Morrislaptop\SymfonyCustomNormalizers\Tests;

use DateTime;
use DatePeriod;
use DateInterval;
use Carbon\Carbon;
use Brick\Money\Money;
use DateTimeImmutable;
use Brick\DateTime\LocalDate;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Serializer;
use Morrislaptop\SymfonyCustomNormalizers\CarbonNormalizer;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Morrislaptop\SymfonyCustomNormalizers\LocalDateNormalizer;
use Symfony\Component\Serializer\Normalizer\ArrayDenormalizer;
use Morrislaptop\SymfonyCustomNormalizers\DatePeriodNormalizer;
use Morrislaptop\SymfonyCustomNormalizers\MoneyNormalizer;
use Morrislaptop\SymfonyCustomNormalizers\ParsableDenormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Normalizer\DateIntervalNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeZoneNormalizer;
use Symfony\Component\Serializer\Normalizer\JsonSerializableNormalizer;

class MoneyNormalizerTest extends TestCase
{
    /** @test */
    public function it_can_normalize_money()
    {
        // Arrange.
        $money = Money::of(50, 'USD'); // USD 50.00
        $serializer = new Serializer([
            new MoneyNormalizer,
        ]);

        // Act.
        $normalized = $serializer->normalize($money);

        // Assert.
        $this->assertEquals(['minor' => 5000, 'currency' => 'USD'], $normalized);
    }

    /** @test */
    public function it_can_denormalize_money()
    {
        // Arrange.
        $normalized = [
            'minor' => 5000,
            'currency' => 'USD',
        ];
        $serializer = new Serializer([
            new MoneyNormalizer,
        ]);

        // Act.
        $denormalized = $serializer->denormalize($normalized, Money::class);

        // Assert.
        $this->assertInstanceOf(Money::class, $denormalized);
        $this->assertEquals('$50.00', $denormalized->formatTo('en_US'));
    }
}
