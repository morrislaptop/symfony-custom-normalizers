<?php

namespace Morrislaptop\SymfonyCustomNormalizers;

use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * A normalizer that uses an objects own Stringable implementation.
 *
 * @author Craig Morris <craig.michael.morris@gmail.com>
 */
class StringableNormalizer implements NormalizerInterface, CacheableSupportsMethodInterface
{
    /**
     * {@inheritdoc}
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        if (! $object instanceof \Stringable && ! method_exists($object, '__toString')) {
            throw new InvalidArgumentException(sprintf('The object must implement "%s or __toString()".', \Stringable::class));
        }

        return $object->__toString();
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof \Stringable || method_exists($data, '__toString');
    }

    /**
     * {@inheritdoc}
     */
    public function hasCacheableSupportsMethod(): bool
    {
        return __CLASS__ === static::class;
    }
}
