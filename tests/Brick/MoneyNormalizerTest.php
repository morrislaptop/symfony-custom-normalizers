<?php

namespace Morrislaptop\SymfonyCustomNormalizers\Tests\Brick;

use Brick\Money\Money;
use Morrislaptop\SymfonyCustomNormalizers\Brick\MoneyNormalizer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Serializer;

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
        $this->assertEquals(['amount' => 5000, 'currency' => 'USD'], $normalized);
    }

    /** @test */
    public function it_can_denormalize_money()
    {
        // Arrange.
        $normalized = [
            'amount' => 5000,
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
