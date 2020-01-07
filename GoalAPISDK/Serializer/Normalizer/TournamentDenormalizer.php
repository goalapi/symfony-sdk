<?php declare(strict_types=1);
/**
 * Author: Murat Erkenov
 * Date/Time: 11/30/16/11:46 AM
 *
 */

namespace GoalAPI\SDKBundle\GoalAPISDK\Serializer\Normalizer;

use GoalAPI\SDKBundle\Model;
use GoalAPI\SDKBundle\Serializer\Denormalizer;

class TournamentDenormalizer extends Denormalizer
{

    /**
     * @inheritdoc
     */
    public function supportsDenormalization($object,string $type, string $format = null)
    {

        if ($type != Model\Tournament::class) {
            return false;
        }
        if (!is_object($object)) {
            return false;
        }
        if (!isset($object->id)) {
            return false;
        }
        if (!isset($object->name)) {
            return false;
        }

        return true;
    }

    /**
     * @inheritdoc
     * @return Model\Tournament
     */
    public function denormalize($object,string $class, string $format = null, array $context = array())
    {
        $tournament = new Model\Tournament($object->id);
        $tournament->setName($object->name);

        if (isset($object->teams_type)) {
            $tournament->setTeamsType($object->teams_type);
        }

        if (isset($object->season)) {
            /** @var Model\Season $season */
            $season = $this->denormalizer->denormalize(
                $object->season,
                Model\Season::class,
                $format,
                $context
            );
            $tournament->setActiveSeason($season);
        }

        if (isset($object->coverage)) {
            /** @var Model\Territory $coverage */
            $coverage = $this->denormalizer->denormalize(
                $object->coverage,
                Model\Territory::class,
                $format,
                $context
            );
            $tournament->setCoverage(
                $coverage
            );
        }

        return $tournament;
    }
}
