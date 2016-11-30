<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 11/30/16/11:46 AM
 *
 */

namespace GoalAPI\SDKBundle\Serializer\Denormalizer;

use GoalAPI\SDKBundle\Model;
use GoalAPI\SDKBundle\Serializer\Denormalizer;

class TournamentDenormalizer extends Denormalizer
{

    /**
     * @inheritdoc
     */
    public function supportsDenormalization($data, $type, $format = null)
    {
        if ($type != Model\Tournament::class) {
            return false;
        }
        if (!is_object($data)) {
            return false;
        }
        if (!isset($data->id)) {
            return false;
        }
        if (!isset($data->name)) {
            return false;
        }

        return true;
    }

    /**
     * @inheritdoc
     */
    public function denormalize($data, $class, $format = null, array $context = array())
    {
        $tournament = new Model\Tournament();
        $tournament->setId($data->id);
        $tournament->setName($data->name);

        return $tournament;
    }
}