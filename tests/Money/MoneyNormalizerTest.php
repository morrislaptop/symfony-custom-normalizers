<?php

namespace Morrislaptop\SymfonyCustomNormalizers\Tests\Money;

use Money\Money;
use Morrislaptop\SymfonyCustomNormalizers\Money\MoneyNormalizer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Serializer;

class MoneyNormalizerTest extends TestCase
{
    /** @test */
    public function it_can_normalize_money()
    {
        // Arrange.
        $money = Money::USD(5000, 'USD'); // USD 50.00
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
        $this->assertEquals('5000', $denormalized->getAmount());
        $this->assertEquals('USD', $denormalized->getCurrency()->getCode());
    }
}
