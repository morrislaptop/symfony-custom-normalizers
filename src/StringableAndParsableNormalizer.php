<?php

namespace Morrislaptop\SymfonyCustomNormalizers;

use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

/**
 * For classes which implement __toString() and parse($str)
 */
class StringableAndParsableNormalizer extends NormalizeIfDenormalizableNormalizer
{
    public function __construct(NormalizerInterface $normalizer = null, DenormalizerInterface $denormalizer = null)
    {
        parent::__construct(
            $normalizer ?? new StringableNormalizer,
            $denormalizer ?? new ParsableDenormalizer,
        );
    }
}
