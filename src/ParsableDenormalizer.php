<?php

namespace Morrislaptop\SymfonyCustomNormalizers;

use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

/**
 * Denormalizes strings to objects through a parse method.
 *
 * @author Craig Morris <craig.michael.morris@gmail.com>
 *
 * @final
 */
class ParsableDenormalizer implements DenormalizerInterface, CacheableSupportsMethodInterface
{
    /**
     * {@inheritdoc}
     */
    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        return class_exists($type) ? $type::parse($data) : null;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, string $type, string $format = null, array $context = []): bool
    {
        return class_exists($type) && method_exists($type, 'parse');
    }

    /**
     * {@inheritdoc}
     */
    public function hasCacheableSupportsMethod(): bool
    {
        return __CLASS__ === static::class;
    }
}
