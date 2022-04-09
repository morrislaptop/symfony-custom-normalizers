<?php

namespace Morrislaptop\SymfonyCustomNormalizers;

use InvalidArgumentException;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;
use Symfony\Component\Serializer\Normalizer\NormalizerInterface;
use WMDE\EmailAddress\EmailAddress;

class EmailAddressNormalizer implements NormalizerInterface, DenormalizerInterface
{
    /**
     * @inheritdoc
     */
    public function normalize($object, string $format = null, array $context = [])
    {
        if (! $object instanceof EmailAddress) {
            throw new InvalidArgumentException('Cannot serialize an object that is not an EmailAddress in EmailAddressNormalizer.');
        }

        return (string) $object;
    }

    /**
     * @inheritdoc
     */
    public function supportsNormalization($data, string $format = null)
    {
        return $data instanceof EmailAddress;
    }

    /**
     * @inheritDoc
     */
    public function denormalize($data, string $type, string $format = null, array $context = [])
    {
        return new EmailAddress($data);
    }

    /**
     * @inheritDoc
     */
    public function supportsDenormalization($data, string $type, string $format = null)
    {
        return is_a($type, EmailAddress::class, true);
    }
}
