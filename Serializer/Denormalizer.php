<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 11/29/16/7:20 PM
 *
 */

namespace GoalAPI\SDKBundle\Serializer;

use Symfony\Component\Serializer\Normalizer\DenormalizerAwareInterface;
use Symfony\Component\Serializer\Normalizer\DenormalizerAwareTrait;
use Symfony\Component\Serializer\Normalizer\DenormalizerInterface;

abstract class Denormalizer implements DenormalizerInterface, DenormalizerAwareInterface
{
    use DenormalizerAwareTrait;
}
