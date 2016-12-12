<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 12/12/16/6:41 PM
 *
 */

namespace GoalAPI\SDKBundle\GoalAPISDK\Serializer\Normalizer;

use GoalAPI\SDKBundle\Model;
use GoalAPI\SDKBundle\Serializer\Denormalizer;

class PlayerInSquadDenormalizer extends Denormalizer
{

    /**
     * @inheritdoc
     * @return Model\PlayerInSquad
     */
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        /** @var Model\Player $player */
        $player = $this->denormalizer->denormalize($data, Model\Player::class, $format, $context);

        $playerInSquad = new Model\PlayerInSquad();
        $playerInSquad->setPlayer($player);
        if (isset($data->role)) {
            $playerInSquad->setPosition($data->role);
        }
        if (isset($data->number)) {
            $playerInSquad->setNumber($data->number);
        }

        return $playerInSquad;
    }

    /**
     * @inheritdoc
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        if ($type != Model\PlayerInSquad::class) {
            return false;
        }

        return true;
    }
}
