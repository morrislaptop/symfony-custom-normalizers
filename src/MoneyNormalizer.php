<?php

namespace Morrislaptop\SymfonyCustomNormalizers;

use DatePeriod;
use DateInterval;
use Carbon\Carbon;
use Brick\Money\Money;
use DateTimeInterface;
use Carbon\CarbonInterface;
use InvalidArgumentException;
use Illuminate\Support\Facades\Date;
use Symfony\Component\Serializer\SerializerAwareTrait;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

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
