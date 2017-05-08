<?php
/**
 * Author: Murat Erkenov
 * Date/Time: 12/8/16/12:26 AM
 *
 */

namespace GoalAPI\SDKBundle\GoalAPISDK\Serializer\Normalizer;

use GoalAPI\SDKBundle\Model;
use GoalAPI\SDKBundle\Serializer\Denormalizer;

class StageDenormalizer extends Denormalizer
{

    /**
     * @inheritdoc
     */
    public function supportsDenormalization($object, $type, $format = null)
    {
        if ($type != Model\Stage::class) {
            return false;
        }
        if (!is_object($object)) {
            return false;
        }
        if (!isset($object->name)) {
            return false;
        }

        return true;
    }

    /**
     * @inheritdoc
     * @return Model\Stage
     */
    public function denormalize($object, $class, $format = null, array $context = array())
    {
        $stage = new Model\Stage();
        if (isset($object->_links->self)) {
            $link = $object->_links->self->href;
            $link = trim($link, '/');
            $link = explode('/', $link);
            $stage->setId($link[1].'.'.$link[3].'.'.$link[5]);
        }

        if (isset($object->_links->standings->href)) {
            $stage->setHasStandings(true);
        } else {
            $stage->setHasStandings(false);
        }

        $stage->setName($object->name);

        if (isset($object->season)) {
            /** @var Model\Season $season */
            $season = $this->denormalizer->denormalize(
                $object->season,
                Model\Season::class,
                $format,
                $context
            );
            $stage->setSeason(
                $season
            );
        }

        if (isset($object->tournament)) {
            /** @var Model\Tournament $tournament */
            $tournament = $this->denormalizer->denormalize(
                $object->tournament,
                Model\Tournament::class,
                $format,
                $context
            );
            $stage->setTournament(
                $tournament
            );
        }

        return $stage;
    }
}
