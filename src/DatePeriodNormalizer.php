<?php

namespace Morrislaptop\SymfonyCustomNormalizers;

use DateInterval;
use DatePeriod;
use DateTimeInterface;
use InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\SerializerAwareTrait;

class DatePeriodNormalizer implements NormalizerInterface, DenormalizerInterface, NormalizerAwareInterface, DenormalizerAwareInterface
{
    use NormalizerAwareTrait, DenormalizerAwareTrait;

    /**
     * @inheritdoc
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        if (! $object instanceof DatePeriod) {
            throw new InvalidArgumentException('Cannot serialize an object that is not a DatePeriod in DatePeriodNormalizer.');
        }

        return [
            'start' => $this->normalizer->normalize($object->getStartDate(), DateTimeInterface::class),
            'interval' => $this->normalizer->normalize($object->getDateInterval(), DateInterval::class),
            'end' => $this->normalizer->normalize($object->getEndDate(), DateTimeInterface::class),
        ];
    }

    /**
     * @inheritdoc
     */
    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof DatePeriod;
    }

    /**
     * @inheritDoc
     */
    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        return new DatePeriod(
            $this->denormalizer->denormalize($data['start'], DateTimeInterface::class),
            $this->denormalizer->denormalize($data['interval'], DateInterval::class),
            $this->denormalizer->denormalize($data['end'], DateTimeInterface::class),
        );
    }

    /**
     * @inheritDoc
     */
    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return is_a($type, DatePeriod::class, true);
    }
}
