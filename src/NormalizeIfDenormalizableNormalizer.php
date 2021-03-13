<?php

namespace Morrislaptop\SymfonyCustomNormalizers;

use Symfony\Component\Serializer\Exception\InvalidArgumentException;
use Symfony\Component\Serializer\Exception\LogicException;
use Symfony\Component\Serializer\Normalizer\CacheableSupportsMethodInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * A meta normalizer which will only normalize if it can be denormalized.
 *
 * Useful for classes which implement __toString() and parse($str).
 *
 * This normalizer will still denormalize if possible.
 */
class NormalizeIfDenormalizableNormalizer implements NormalizerInterface, DenormalizerInterface, CacheableSupportsMethodInterface
{
    protected NormalizerInterface $normalizer;

    protected DenormalizerInterface $denormalizer;

    public function __construct(NormalizerInterface $normalizer = null, DenormalizerInterface $denormalizer = null)
    {
        $this->normalizer = $normalizer ?? new StringableNormalizer;
        $this->denormalizer = $denormalizer ?? new ParsableDenormalizer;
    }

    /**
     * {@inheritdoc}
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        return $this->normalizer->normalize($object, $format, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function supportsNormalization($data, string $format = null)
    {
        $canNormalize = $this->normalizer->supportsNormalization($data, $format);
        $canDenormalize = $this->denormalizer->supportsDenormalization($data, get_class($data), $format);

        return $canDenormalize && $canNormalize;
    }

    /**
     * {@inheritdoc}
     */
    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return $this->denormalizer->supportsDenormalization($data, $type, $format);
    }

    /**
     * {@inheritdoc}
     */
    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        return $this->denormalizer->denormalize($data, $type, $format, $context);
    }

    /**
     * {@inheritdoc}
     */
    public function hasCacheableSupportsMethod(): bool
    {
        $normalizerSupport = $this->normalizer instanceof CacheableSupportsMethodInterface && $this->normalizer->hasCacheableSupportsMethod();
        $denormalizerSupport = $this->denormalizer instanceof CacheableSupportsMethodInterface && $this->denormalizer->hasCacheableSupportsMethod();

        return $normalizerSupport && $denormalizerSupport;
    }
}
