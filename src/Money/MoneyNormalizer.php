<?php

namespace Morrislaptop\SymfonyCustomNormalizers\Money;

use InvalidArgumentException;
use Money\Currency;
use Money\Money;
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
            'minor' => $object->getAmount(),
            'currency' => $object->getCurrency()->getCode(),
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
        return new Money($data['minor'], new Currency($data['currency']));
    }

    /**
     * @inheritDoc
     */
    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return is_a($type, Money::class, true);
    }
}
