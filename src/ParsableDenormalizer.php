<?php

namespace Morrislaptop\SymfonyCustomNormalizers;

use Carbon\Carbon;
use Carbon\CarbonInterface;
use Illuminate\Support\Facades\Date;
use InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;

class ParsableDenormalizer implements DenormalizerInterface
{
    /**
     * @inheritDoc
     */
    public function denormalize($data, $class, string $format = null, array $context = [])
    {
        return $class::parse($data);
    }

    /**
     * @inheritDoc
     */
    public function supportsDenormalization($data, $type, string $format = null)
    {
        return method_exists($type, 'parse');
    }
}
