<?php

namespace Morrislaptop\SymfonyCustomNormalizers;

use Brick\Money\Money;
use InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class MoneyNormalizer implements NormalizerInterface, DenormalizerInterface
{
    /**
     * @inheritdoc
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        if (! $object instanceof Money) {
            throw new InvalidArgumentException('Cannot serialize an object that is not a Money in MoneyNormalizer.');
        }

        return [
            'minor' => $object->getMinorAmount()->toInt(),
            'currency' => $object->getCurrency()->getCurrencyCode(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof Money;
    }

    /**
     * @inheritDoc
     */
    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        return Money::ofMinor($data['minor'], $data['currency']);
    }

    /**
     * @inheritDoc
     */
    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return is_a($type, Money::class, true);
    }
}
