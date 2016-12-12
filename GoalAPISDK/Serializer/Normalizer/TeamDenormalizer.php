<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 12/11/16/9:29 AM
 *
 */

namespace GoalAPI\SDKBundle\GoalAPISDK\Serializer\Normalizer;

use GoalAPI\SDKBundle\Model;
use GoalAPI\SDKBundle\Serializer\Denormalizer;
use Symfony\Component\HttpFoundation\ParameterBag;

class TeamDenormalizer extends Denormalizer
{

    /**
     * @inheritdoc
     * @return Model\Team
     */
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        if (!is_object($data)) {
            throw new \InvalidArgumentException('Only \stdClass objects can be denormalized by PlayerDenormalizer');
        }
        if (!isset($data->id)) {
            throw new \InvalidArgumentException('The first argument must have `id` property');
        }

        $team = new Model\Team();
        $team->setId($data->id);

        if (isset($data->name)) {
            $team->setName($data->name);
        }

        if (isset($data->type)) {
            $team->setType($data->type);
        }

        if (isset($data->names) && is_object($data->names)) {
            $names = new ParameterBag((array)$data->names);
            $team->setNames($names);
        }

        if (isset($data->country) && is_object($data->country)) {
            /** @var Model\Territory $country */
            $country = $this->denormalizer->denormalize($data->country, Model\Territory::class, $format, $context);
            $team->setCountry($country);
        }

        return $team;
    }

    /**
     * @inheritdoc
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        if ($type != Model\Team::class) {
            return false;
        }

        return true;
    }
}
