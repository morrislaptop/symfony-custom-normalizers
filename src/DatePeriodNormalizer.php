<?php

namespace Morrislaptop\SymfonyCustomNormalizers;

use DatePeriod;
use Carbon\Carbon;
use Carbon\CarbonInterface;
use DateInterval;
use DateTimeInterface;
use InvalidArgumentException;
use Illuminate\Support\Facades\Date;
use Symfony\Component\Serializer\SerializerAwareTrait;
use Symfony\Component\Serializer\SerializerAwareInterface;
use Symfony\Component\Serializer\Normalizer\ObjectNormalizer;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

class DatePeriodNormalizer implements NormalizerInterface, DenormalizerInterface, SerializerAwareInterface
{
    use SerializerAwareTrait;

    /**
     * @inheritdoc
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        if (! $object instanceof DatePeriod) {
            throw new InvalidArgumentException('Cannot serialize an object that is not a DatePeriod in DatePeriodNormalizer.');
        }

        return [
            'start' => $this->serializer->normalize($object->start, DateTimeInterface::class),
            'interval' => $this->serializer->normalize($object->interval, DateInterval::class),
            'end' => $this->serializer->normalize($object->end, DateTimeInterface::class),
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
            $this->serializer->denormalize($data['start'], DateTimeInterface::class),
            $this->serializer->denormalize($data['interval'], DateInterval::class),
            $this->serializer->denormalize($data['end'], DateTimeInterface::class),
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
