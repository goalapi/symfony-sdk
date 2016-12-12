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

class PlayerDenormalizer extends Denormalizer
{

    /**
     * @inheritdoc
     * @return Model\Player
     */
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        if (!is_object($data)) {
            throw new \InvalidArgumentException('Only \stdClass objects can be denormalized by PlayerDenormalizer');
        }
        if (!isset($data->id)) {
            throw new \InvalidArgumentException('The first argument must have `id` property');
        }

        $player = new Model\Player();
        $player->setId($data->id);

        if (isset($data->name)) {
            $player->setName($data->name);
        }

        if (isset($data->position)) {
            $player->setPosition($data->position);
        }

        if (isset($data->names) && is_object($data->names)) {
            $names = new ParameterBag((array)$data->names);
            $player->setNames($names);
        }

        if (isset($data->bio) && is_object($data->bio)) {
            $bio = new ParameterBag((array)$data->bio);
            $player->setBio($bio);
        }

        if (isset($data->country) && is_object($data->country)) {
            /** @var Model\Territory $country */
            $country = $this->denormalizer->denormalize($data->country, Model\Territory::class, $format, $context);
            $player->setCountry($country);
        }

        return $player;
    }

    /**
     * @inheritdoc
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        if ($type != Model\Player::class) {
            return false;
        }
        return true;
    }
}
