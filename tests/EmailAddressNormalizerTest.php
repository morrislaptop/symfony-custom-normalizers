<?php

namespace Morrislaptop\SymfonyCustomNormalizers\Tests;

use Morrislaptop\SymfonyCustomNormalizers\EmailAddressNormalizer;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Serializer\Serializer;
use WMDE\EmailAddress\EmailAddress;

class EmailAddressNormalizerTest extends TestCase
{
    /** @test */
    public function it_can_normalize_an_email_instance()
    {
        // Arrange.
        $email = new EmailAddress('test@test.com');

        // Arrange.
        $serializer = new Serializer([
            new EmailAddressNormalizer,
        ]);

        // Act.
        $normalized = $serializer->normalize($email);

        // Assert.
        $this->assertEquals('test@test.com', $normalized);
    }

    /** @test */
    public function it_can_denormalize_an_email()
    {
        // Arrange.
        $normalized = 'test@test.com';
        $serializer = new Serializer([
            new EmailAddressNormalizer,
        ]);

        // Act.
        $denormalized = $serializer->denormalize($normalized, EmailAddress::class);

        // Assert.
        $this->assertInstanceOf(EmailAddress::class, $denormalized);
        $this->assertEquals('test.com', $denormalized->getDomain());
    }
}
