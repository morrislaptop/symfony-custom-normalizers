<?php

namespace Morrislaptop\SymfonyCustomNormalizers\Tests;

use DateInterval;
use DatePeriod;
use DateTime;
use Morrislaptop\SymfonyCustomNormalizers\DatePeriodNormalizer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Normalizer\DateIntervalNormalizer;
use Symfony\Component\Serializer\Normalizer\DateTimeNormalizer;
use Symfony\Component\Serializer\Serializer;

class DatePeriodNormalizerTest extends TestCase
{
    /** @test */
    public function it_can_normalize_a_date_period_instance()
    {
        // Arrange.
        $begin = new DateTime('2012-08-01');
        $end = new DateTime('2012-08-02');
        $interval = new DateInterval('P1D');
        $period = new DatePeriod($begin, $interval, $end);

        // Arrange.
        $serializer = new Serializer([
            new DatePeriodNormalizer,
            new DateIntervalNormalizer,
            new DateTimeNormalizer,
        ]);

        // Act.
        $normalized = $serializer->normalize($period);

        // Assert.
        $this->assertEquals([
            'start' => '2012-08-01T00:00:00+00:00',
            'interval' => 'P0Y0M1DT0H0M0S',
            'end' => '2012-08-02T00:00:00+00:00',
        ], $normalized);
    }

    /** @test */
    public function it_can_denormalize_a_date_period_object()
    {
        // Arrange.
        $normalized = [
            'start' => '2012-08-01T00:00:00+00:00',
            'interval' => 'P0Y0M1DT0H0M0S',
            'end' => '2012-08-02T00:00:00+00:00',
        ];
        $serializer = new Serializer([
            new DatePeriodNormalizer,
            new DateIntervalNormalizer,
            new DateTimeNormalizer,
        ]);

        // Act.
        $denormalized = $serializer->denormalize($normalized, DatePeriod::class);

        // Assert.
        $this->assertInstanceOf(DatePeriod::class, $denormalized);
        $this->assertEquals(1, iterator_count($denormalized));
    }
}
